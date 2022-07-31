<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
	@include('layouts.header')
	@stack('customcss')
</head>
<body>
	<!-- begin #page-loader -->
	<div id="page-loader" class="fade show">
		<span class="spinner"></span>
	</div>
	<!-- end #page-loader -->

	<!-- begin #page-container -->
	<div id="page-container" class="page-container fade page-sidebar-fixed page-header-fixed">
		<!-- begin #header -->
		@include('layouts.navbar')
		<!-- end #header -->

		<!-- begin #sidebar -->
		@include('layouts.sidebar')
		<!-- end #sidebar -->

		<!-- begin #content -->
		<div id="content" class="content">
			<!-- begin breadcrumb -->
			@include('layouts.breadcrumbs')
			<!-- end breadcrumb -->
			<!-- begin page-header -->
			<h1 class="page-header">
				@yield('page-header')
			</h1>
			<!-- end page-header -->
			<!-- begin panel -->

			@yield('content')
			<!-- end panel -->
		</div>
		<!-- end #content -->

		<!-- begin scroll to top btn -->
		<a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
		<!-- end scroll to top btn -->
	</div>
	<!-- end page container -->

	<!-- ================== BEGIN BASE JS ================== -->
	<script src="/assets/js/app.min.js"></script>
	<script src="/assets/js/theme/default.min.js"></script>
	<script src="/assets/plugins/select2/dist/js/select2.min.js"></script>
	<script src="/assets/plugins/select2/dist/js/i18n/es.js"></script>
	<script src="/assets/plugins/sweetalert/dist/sweetalert.min.js" type="text/javascript"></script>
	<!-- Utilerias -->
	<script src="/assets/js/utils/func.js"></script>
	<script src="/assets/js/utils/plugins.js"></script>
	<!-- ================== END BASE JS ================== -->
	@stack('customjs')
</body>
</html>