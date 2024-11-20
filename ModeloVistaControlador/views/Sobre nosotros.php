<?php 
session_start();
include_once("views/header/header.php"); ?>

<div class="container sobreNosotros">
    <div class="row d-flex justify-content-center">
        <div class="col-sm-12 col-sm-7 col-lg-7">
            <div class="row">
                <!-- Sección del icono -->
                <div class="col-12 d-flex flex-column justify-content-start">
                    <div id="seccion-sobre-nosotros">
                        <div class="icono-grupo d-flex justify-content-center w-100">
                            <img src="imagenes/Iconos/custom-groups-24.svg" class="d-flex justify-content-start" alt="sobre nosotros" width="125px">
                        </div> 
                    </div>
                </div>
                <!-- Contenido sobre nosotros -->
                <div id="contenido-sobre-nosotros col-12 p-5">
                    <div class="migas-de-pan ">
                        <!-- Migas de pan -->
                        <a href="?controller=producto">Inicio</a>
                        <p>-</p>
                        <a href="?controller=producto&action=sobreNosotros">Sobre nosotros</a>
                    </div>
                    <h1 class="p-0">Sobre nosotros</h1>
                    <span class="descripcion">
                    Creating with Super is more than just building a website; it's about enabling you to communicate with and connect to your audience. Our automatic optimizations take care of the technicalities, so you can focus on creating engaging content, delivered at unbeatable speeds.
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
