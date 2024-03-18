<?php 
            foreach($alertas as $tipo => $mensajes){?>
                <?php foreach($mensajes as $mensaje){?>

                    <p  class="alertas <?php echo $tipo;?>"><?php echo $mensaje ;?></p>

              <?php  } ;?>

                
            <?php };?>
