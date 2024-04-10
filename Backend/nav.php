<?php



?>
<!--left-fixed -navigation-->
<div class="sidebar" role="navigation">
	<div class="navbar-collapse">
		<nav class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-right dev-page-sidebar mCustomScrollbar _mCS_1 mCS-autoHide mCS_no_scrollbar" id="cbp-spmenu-s1">
			<div class="scrollbar scrollbar1">
				<ul class="nav" id="side-menu">
					<li>
						<a href="./" class="active"><i class="fa fa-home nav_icon"></i>Inicio </a>
					</li>
					


                    <?php

                     if ($permiso!=4) {
                    ?>
                        <li>
                            <a class="collapse-item" href="#" onclick="cargar('AdminClientes','adm/Clientes.php','Controller')"><i class="fa fa-users nav_icon"></i> Crear Pacientes</a>
                        </li>
                         <li>
                             <a class="collapse-item" href="#" onclick="cargar('AdminInventario','adm/inventario.php','Controller')"><i class="fa fa-cogs nav_icon"></i> Inventario Precios</a>
                         </li>

                    <?php
                    }
                    ?>
                        <li>
                            <a class="collapse-item" href="#" onclick="cargar('AdminCitas2','adm/Citas.php','Controller')"> <i class="fa fa-calendar nav_icon"></i> Crear Cita</a>
                        </li>
                        <li>
                            <a class="collapse-item" href="#" onclick="cargar('ReporteCitas','adm/reporteCitas.php','Controller')"><i class="fa fa-book-open nav_icon"></i> Reporte de Cita</a>
                        </li>
                        <li>
                             <a class="collapse-item" href="#" onclick="cargar('AtenderCitas','adm/AtenderCitas.php','Controller')"><i class="fa fa-comment nav_icon"></i> Atender Cita</a>
                        </li>
                        <?php
                         if ($permiso!=4) {
                        ?>
                            <li>
                                 <a class="collapse-item" href="#" onclick="cargar('VerHistorialTodos','adm/Historial.php','Controller')"><i class="fa fa-book-open nav_icon"></i> Seguimiento Dental</a>
                            </li>
                             <li>
                                 <a class="collapse-item" href="#" onclick="cargar('ReporteFinanciero','adm/reporteFinanciero.php','Controller')"><i class="fa fa-money-bill nav_icon"></i> Reporte Financiero</a>
                             </li>
                             <li>
                                 <a class="collapse-item" href="#" onclick="cargar('ReporteHorarioSR','adm/reporteHorarioSR.php','Controller')"><i class="fa fa-list nav_icon"></i> Reporte Horario <br> sin reservar</a>
                             </li>
                             <li>
                                 <a class="collapse-item" href="#" onclick="cargar('ListarUsuarios','adm/usuarios.php','Controller')"><i class="fa fa-users nav_icon"></i> Usuarios</a>
                             </li>

                        <?php
                        }
                        ?>

				</ul>
			</div>
			<div class="scrollbar scrollbar1">
				<ul class="nav" id="side-menu">
					
				</ul>
			</div>
			<!-- //sidebar-collapse -->
		</nav>
		
	</div>
</div>
			<!--left-fixed -navigation-->