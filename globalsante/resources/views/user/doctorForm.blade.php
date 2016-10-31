<div class="control-group">
  <!-- E-mail -->
  <label class="control-label" for="email">Informartion</label>
  <div class="form-group">
  	@if($errors->has('info'))
      <div class="form-group haserror">
    @else
      <div class="form-group">
    @endif 
    <textarea name="info" class="form-control" required></textarea>
    <!-- <input type="text" id="email" name="email" placeholder="" class="form-control">			       -->
  </div>
</div>	
<div class="control-group">
  <!-- E-mail -->
  <label class="control-label" for="email">Phone</label>
  <div class="form-group">
  	@if($errors->has('phone'))
      <div class="form-group haserror">
    @else
      <div class="form-group">
    @endif 
    <!-- <textarea name="info" class="form-control"></textarea> -->
    <input type="text" id="phone" name="phone" placeholder="" class="form-control" required>			      
  </div>
</div>	