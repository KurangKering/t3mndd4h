@extends('layouts.layout')
@section('css-inline')
<style>
	.section .section-header {
		display: block;
		text-align: center;
	}
</style>
@endsection
@section('content')
<section class="section">
	<div class="section-header" >
		<h1 class="mt-4">
			SELAMAT DATANG DI SISTEM INFORMASI HAJI
		</h1>
	</div>
	
	<div class="row">
		<div class="col-lg-12 col-md-12 col-12 col-sm-12">
			<div class="card">
				<img width="100%" src="{{ base_url('assets/img/tata_cara.jpg') }}" alt="">
				
				
			</div>
		</div>

	</div>

	



</section>
@endsection
