@extends("layout")

@section("content")
	<section class="row">
		<div class="col-md-12 col-sm-12 col-xs-12 nopadding">
			<table class="table table-hover">
				<thead>
					<tr>
						<th>Horaire</th>
						<th>Durée</th>
						<th>Status</th>
						<th>Patient</th>
						<th>Téléphone</th>
						<th>Motif de consultation</th>
						<th>Notes</th>
						<th>Type d’assurance</th>
						<th>Provenance</th>
						<th>Action</th>
					</tr>
				</thead>

				<tbody>

					@foreach($agenda as $agendas)
					<tr>
						<td></td>
						<td>{{$agendas->duration}}</td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					@endforeach
				</tbody>
				
			</table>
		</div>

	</section>


@endsection


@section('js')
@parent

@stop