@extends("layout")

@section("content")
<div id="wrapper">
    <!-- Sidebar -->
       @extends('parameters.sidebar')
    <!-- /#sidebar-wrapper -->

    <!-- Page Content -->
    <div id="page-content-wrapper">
        <div class="container-fluid">
            <div class="row">
            	<div class="col-md-12 col-sm-12 col-xs-12 nopadding">
            	  <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Motif de consultation</th>
                                <th>Durée moyenne</th>
                                <th>Réservable en ligne</th>
                                <th>Prix par défaut</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div style="width:50px;height:50px; background:red;"></div>
                                </td>
                                <td>
                                    <input type="text" name="mc" value="Première consultation" class="form-control">
                                </td>
                                <td>
                                    <select class="form-control">
                                       <option value="5">5 min</option>
                                        <option value="6">6 min</option>
                                        <option value="10">10 min</option>
                                        <option value="12">12 min</option>
                                        <option value="15" selected="selected">15 min</option>
                                        <option value="20">20 min</option>
                                        <option value="24">24 min</option>
                                        <option value="25">25 min</option>
                                        <option value="30">30 min</option>
                                        <option value="35">35 min</option>
                                        <option value="40">40 min</option>
                                        <option value="45">45 min</option>
                                        <option value="50">50 min</option>
                                        <option value="55">55 min</option>
                                        <option value="60">1h</option>
                                        <option value="65">1h05</option>
                                        <option value="70">1h10</option>
                                        <option value="75">1h15</option>
                                        <option value="80">1h20</option>
                                        <option value="85">1h25</option>
                                        <option value="90">1h30</option>
                                        <option value="95">1h35</option>
                                        <option value="100">1h40</option>
                                        <option value="105">1h45</option>
                                        <option value="110">1h50</option>
                                        <option value="115">1h55</option>
                                        <option value="120">2h</option>
                                        <option value="135">2h15</option>
                                        <option value="150">2h30</option>
                                        <option value="165">2h45</option>
                                        <option value="180">3h</option>
                                        <option value="195">3h15</option>
                                        <option value="210">3h30</option>
                                        <option value="225">3h45</option>
                                        <option value="240">4h</option>
                                        <option value="255">4h15</option>
                                        <option value="270">4h30</option>
                                        <option value="285">4h45</option>
                                        <option value="300">5h</option>
                                        <option value="315">5h15</option>
                                        <option value="330">5h30</option>
                                        <option value="345">5h45</option>
                                        <option value="360">6h</option>
                                        <option value="480">8h</option>
                                        <option value="600">10h</option>


                                    </select>
                                </td>
                                <td>
                                    <input type="checkbox" name="chk" checked="">
                                </td>
                                <td>                                        
                                    <div class="input-group">
                                      <input type="number" class="form-control">
                                      <span class="input-group-btn">
                                        <button class="btn btn-default" type="button">$</button>
                                      </span>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>   
                  </div>
            	</div>
            </div>
        </div>
    </div>
    <!-- /#page-content-wrapper -->

</div>

   

@endsection

@section('js')
@parent

@stop