@extends('adminlte::page')


@section('content_header')
    <h1><b>Bienvenido {{ $empresa->nombre_empresa }}</b></h1>
    <hr>
@stop

@section('content')
    <div class="row">
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <a href="{{ url('/admin/roles') }}" class="info-box-icon bg-info">
                    <span><i class="fas fa-fw bi-person-check-fill"></i></span>
                </a>
            <div class="info-box-content">
                <span class="info-box-text">Roles registrados</span>
                <span class="info-box-number">{{ $total_roles }} roles</span>
            </div>
            <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>

        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <a href="{{ url('/admin/usuarios') }}" class="info-box-icon bg-primary">
                    <span><i class="fas fa-fw bi bi-person-vcard"></i></span>
                </a>
            <div class="info-box-content">
                <span class="info-box-text">Usuarios registrados</span>
                <span class="info-box-number">{{ $total_usuarios }} usuarios</span>
            </div>
            <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>

        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <a href="{{ url('/admin/categorias') }}" class="info-box-icon bg-warning">
                    <span><i class="fas fa-fw bi bi-tags"></i></span>
                </a>
            <div class="info-box-content">
                <span class="info-box-text">Categorias registradas</span>
                <span class="info-box-number">{{ $total_categoria }} categorias</span>
            </div>
            <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>

        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <a href="{{ url('/admin/productos') }}" class="info-box-icon bg-success">
                    <span><i class="fas fa-fw bi bi-list"></i></span>
                </a>
            <div class="info-box-content">
                <span class="info-box-text">Productos registradas</span>
                <span class="info-box-number">{{ $total_productos }} productos</span>
            </div>
            <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>

        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <a href="{{ url('/admin/proveedores') }}" class="info-box-icon bg-danger">
                    <span><i class="fas fa-fw bi bi-box-seam"></i></span>
                </a>
            <div class="info-box-content">
                <span class="info-box-text">Proveedores registradas</span>
                <span class="info-box-number">{{ $total_proveedores }} proveedores</span>
            </div>
            <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>

        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <a href="{{ url('/admin/compras') }}" class="info-box-icon bg-secondary">
                    <span><i class="fas fa-fw bi bi-cart-plus"></i></span>
                </a>
            <div class="info-box-content">
                <span class="info-box-text">Compras registradas</span>
                <span class="info-box-number">{{ $total_compras }} compra</span>
            </div>
            <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>

        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <a href="{{ url('/admin/clientes') }}" class="info-box-icon bg-info">
                    <span><i class="fas fa-fw bi bi-person-arms-up"></i></span>
                </a>
            <div class="info-box-content">
                <span class="info-box-text">Clientes registradas</span>
                <span class="info-box-number">{{ $total_clientes }} clientes</span>
            </div>
            <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>

        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <a href="{{ url('/admin/arqueos') }}" class="info-box-icon bg-info">
                    <span><i class="fas fa-fw bi bi-file-spreadsheet"></i></span>
                </a>
            <div class="info-box-content">
                <span class="info-box-text">Arqueos registradas</span>
                <span class="info-box-number">{{ $total_arqueos }} arqueos</span>
            </div>
            <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        
    </div>
    
@stop

@section('css')
    
@stop

@section('js')
    
@stop