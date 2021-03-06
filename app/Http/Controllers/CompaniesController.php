<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Company;
use App\Connection;
use App\Contact;
use App\Event;
use App\Industry;
use App\Leader;
use App\Rfp;
use App\User;

class CompaniesController extends Controller
{
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		$industries = Industry::all();
		$data = compact('industries');
		return view('admin.admin_create_company')->with($data);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$company = new Company();
		return $this->validateAndSave($company, $request);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		$user = Auth::user();
		$company = Company::findOrFail($id);
		$leaders = $company->leaders;
		$industries = Industry::all();
		$data = compact('company', 'industries', 'user');

		return view('companies.edit_company')->with($data);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		$company = Company::findOrFail($id);
		return $this->validateAndSave($company, $request);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		$company = Company::findOrFail($id);
		$company->delete();
		return redirect()->action('ContactsController@destroy', ['id' => $company->id]);
	}

	public function searchMembers(Request $request)
	{
		$industries = Industry::all();
		$current_user_address = Auth::user()->company->contact->address_line_1 . ' ' . Auth::user()->company->contact->city;
		$data = compact('industries', 'current_user_address');
		return view('search_members')->with($data);
	}

	public function getSearchedCompanies(Request $request)
	{
		$data = [];
		$data['results'] = Company::searchMembers($request)->with('contact')->get();
		foreach($data['results'] as &$result) {
			$result->url = action('CompaniesController@show', $result->id);
			$result->industry_title = $result->industry->industry;
		}
		$data['locations'] = Contact::searchLocations($data['results']);
		foreach ($data['locations'] as &$location) {
			$location->company;
		}
		return $data;
	}

	public function dashboard($id)
	{
		$company = Company::find($id);
		$connections = $company->companies;
		$feed_content = $this->buildFeed($connections);
		$users_rfps = $company->rfps->sortBy('deadline');
		$users_events = $company->events->sortBy('from_date');
		$data = compact('feed_content', 'users_rfps', 'users_events', 'company');
		return view('companies.companies_dashboard')->with($data);
	}

	public function viewConnections($id)
	{
		$user = User::find($id)->id;
		$connections = Company::findOrFail($user)->companies;
		$company_events = [];
		$company_rfps = [];
		foreach ($connections as $connection) {
			$rfps = Rfp::profileRfps($connection->id)->get();
			$events = Event::usersEvents($connection->id)->get();
			foreach($rfps as $rfp){
				$company_rfps[] = $rfp;
			}
			foreach($events as $event){
				$company_events[] = $event;
			}
		}
		$data = compact('connections', 'company_events', 'company_rfps');
		return view('companies.all_connections')->with($data);
	}

	public function show($id)
	{
		$company = Company::findOrFail($id);
		$contact = $company->contact;
		$rfps = Rfp::profileRfps($company->id)->get();
		$events = $company->events->sortBy('from_date');
		$leaders = $company->leaders;
		$company_url = Contact::getViewProfileWebsite($contact->website);
		$connections_ids = Connection::getArrayOfConnectionsIds($id);
		$existing_connection = Connection::getExistingConnectionId($id, Auth::user()->id);
		$connections_count = Connection::connectionsCount($id);
		$connections = Company::returnCompaniesFromIds($connections_ids);
		$data = compact('company', 'company_url','contact', 'rfps', 'events', 'leaders', 'connections', 'connections_ids', 'connections_count', 'existing_connection');
		return view('companies.view_profile')->with($data);
	}

	private function validateAndSave(Company $company, Request $request)
	{
		$request->woman_owned = ($request->woman_owned) ? TRUE : FALSE;
		$request->family_owned = ($request->family_owned) ? TRUE : FALSE;
		$request->session()->flash('ERROR_MESSAGE', 'Company information not saved.');
		$this->validate($request, Company::$rules);
		$request->session()->forget('ERROR_MESSAGE');

		if(Auth::user()->is_admin){
			$company->user_id = User::all()->last()->id;
		}
		$company->name = $request->name;
		$company->industry_id = $request->industry_id;
		$company->profile_img = $this->storeImage($request);
		$company->profile_img = $this->storeImage($request);
		$company->desc = $request->desc;
		$company->size = $request->size;
		$company->woman_owned = $request->woman_owned;
		$company->contractor = $this->checkBusinessType($request);
		$company->family_owned = $request->family_owned;
		$company->organization = $this->checkBusinessType($request);
		$company->date_established = $request->date_established;
		$company->save();

		if(Auth::user()->is_admin){
			$request->session()->flash('SUCCESS_MESSAGE', 'Company saved successfully, please enter contact information.');
			return redirect()->action('ContactsController@create');
		} else {
			$request->session()->flash('SUCCESS_MESSAGE', 'Company information saved successfully.');
			return redirect()->action('CompaniesController@edit', ['id' => Auth::user()->id]);
		}
	}

	private function buildFeed($connections)
	{
		$collection = [];
		$dashboard_events = Event::dashboardEvents($connections)->get();
		$dashboard_rfps = RFP::dashboardRfps($connections)->get();
		$dashboard_connections = Connection::dashboardConnections($connections)->get();

		foreach($dashboard_events as $dashboard_event){
			$collection[] = $dashboard_event;
		}

		foreach($dashboard_rfps as $dashboard_rfp){
			$collection[] = $dashboard_rfp;
		}

		foreach ($dashboard_connections as $dashboard_connection) {
			$collection[] = $dashboard_connection;
		}
		$feed = collect($collection);
		foreach($feed as $content){
			if($content->company1_id){
				$content->company1_id = Company::find($content->company1_id);
				$content->company2_id = Company::find($content->company2_id);
 			}
		}
		$test = $feed->sortBy('created_at');
		return $test;
	}

	private function storeImage($request)
	{
		if($request->file('profile_img')){
			$file = $request->file('profile_img')->getClientOriginalName();
			$request->file('profile_img')->move(public_path('profile_img'), $request->file('profile_img')->getClientOriginalName());
			$file_path = public_path('img/uploads/avatars') . '/' . $request->file('profile_img')->getClientOriginalName();
			return $file;
		} elseif ($request->file('header_img')) {
			$file = $request->file('header_img')->getClientOriginalName();
			$request->file('header_img')->move(public_path('header_img'), $request->file('header_img')->getClientOriginalName());
			$file_path = public_path('img/uploads/headers') . '/' . $request->file('header_img')->getClientOriginalName();
			return $file;
		} else {
			return NULL;
		}
	}

	private function checkBusinessType($request)
	{
		if($request->business_type == 'contractor'){
			return 1;
		} elseif($request->business_type == 'organization'){
			return 1;
		} else {
			return 0;
		}
	}
}
