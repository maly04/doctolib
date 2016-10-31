<table>
	<tr>
		<td>Bonjour,</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>{{$patient->first_name}} {{$patient->last_name}} vient de confirmer un RDV.</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>Date : {{$date_email}}.</td>
	</tr>
	<tr>
		<td>Lieu : {{$address}}</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>Contact :</td>
	</tr>
	<tr>
		<td>Nom : {{$patient->last_name}}</td>
	</tr>
	<tr>
		<td>Prénom : {{$patient->first_name}}</td>
	</tr>
	<tr>
		<td>Adresse : {{$patient->user_address}}</td>
	</tr>
	<tr>
		<td>Téléphone : {{$patient->mobile_phone}}</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>Vous pouvez consulter votre agenda ici : {{url("/agenda")}}</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>L'équipe Global Santé.</td>
	</tr>
	
</table>