<div class="form-group">
  <label for="project_title">project_title<span class="required">*</span></label>
  <input type="text" class="form-control"name="project_title" value="{{ $rfp->project_title }}">
    @include ('partials.error', ['value' => 'project_title'])
</div>
<div class="form-group">
	<label for="deadline">Deadline:<span class="required">*</span></label>
	<input type="date" class="form-control" name="deadline" value="{{ $rfp->deadline }}" required>
</div>
<div class="form-group">
  <label for="contact_name">Contact Name<span class="required">*</span></label>
  <input type="text" class="form-control" name="contact_name" value="{{ $rfp->contact_name }}">
  @include ('partials.error', ['value' => 'contact_name'])
</div>
<div class="form-group">
  <label for="contact_department">Contact Department<span class="required">*</span></label>
  <input type="text" class="form-control" name="contact_department" value="{{ $rfp->contact_department }}">
  @include ('partials.error', ['value' => 'contact_department'])
</div>
<div class="form-group">
  <label for="phone_no">Contact Number<span class="required">*</span></label>
  <input type="tel" class="form-control" name="phone_no" value="{{ $rfp->phone_no }}">
  @include ('partials.error', ['value' => 'phone_no'])
</div>
<div class="form-group">
  <label for="project_scope">Project Scope<span class="required">*</span></label>
  <textarea class="form-control" name="project_scope" maxlength="2000" cols="12">{{ $rfp->project_scope }}</textarea>
  @include ('partials.error', ['value' => 'project_scope'])
</div>
<div class="form-group">
	<label for="contract_from_date">Contract From:<span class="required">*</span></label>
	<input type="date" class="form-control" name="contract_from_date" value="{{ $rfp->contract_from_date }}" required>
</div>
<div class="form-group">
	<label for="contract_to_date">Contract To:<span class="required">*</span></label>
	<input type="date" class="form-control" name="contract_to_date" value="{{ $rfp->contract_to_date }}" required>
</div>
