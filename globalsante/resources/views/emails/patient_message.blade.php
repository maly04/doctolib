@extends("layout")
@section("content")
<div class="container">
    <div class="row">
        <div class="col-md-12 col-xs-12 col-sm-12">
      	    <div class="col-md-3 col-xs-3 col-sm-3"></div>
        	<div class="col-md-6 col-xs-6 col-sm-6 alert alert-success">
        		Merci de votre confirmation. Votre compte est désormais activé, vous pouvez vous connecter <a href="{{URL::to('/login#patient')}}">ici</a>
        	</div>
      	    <div class="col-md-3 col-xs-3 col-sm-3"></div>

        </div>
    </div>
</div>
@endsection