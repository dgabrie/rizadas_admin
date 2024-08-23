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

                     if (!array_search(4, $permiso)) {
                    ?>
                    <li>
                        <a href="#"><i class="fa fa-cogs nav_icon"></i>Mantenimiento <span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level collapse">
                            <li>
                                <a class="collapse-item" href="#" onclick="cargar('AdminCategoria','adm/categoria.php','Controller')"><i class="fa fa-cogs nav_icon"></i>Categorias</a>
                            </li>
                             <li>
                                 <a class="collapse-item" href="#" onclick="cargar('AdminSubCategoria','adm/subcategoria.php','Controller')"><i class="fa fa-cogs nav_icon"></i> SubCategorias</a>
                             </li>

                             <li>
                                 <a class="collapse-item" href="#" onclick="cargar('AdminMarca','adm/marca.php','Controller')"><i class="fa fa-copyright nav_icon"></i> Marca</a>
                             </li>

                             <li>
                                 <a class="collapse-item" href="#" onclick="cargar('AdminTemporada','adm/temporada.php','Controller')"><i class="fa fa-book nav_icon"></i> Temporada</a>
                             </li>
                             <li>
                                 <a class="collapse-item" href="#" onclick="cargar('AdminProducto','adm/producto.php','Controller')"><i class="fa fa-book nav_icon"></i> Productos</a>
                             </li>
                                 <li>
                                     <a class="collapse-item" href="#" onclick="cargar('ListarUsuarios','adm/usuarios.php','Controller')"><i class="fa fa-users nav_icon"></i> Usuarios</a>
                                 </li>
                        </ul>
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