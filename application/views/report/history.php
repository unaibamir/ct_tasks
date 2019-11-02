<?php
defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!-- Main panel is starting from here -->

<div class="panel-header panel-header-sm">
</div>

<!-- Dashboard for User -->
<div class="content">
  <div class="row">

    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <h5 class="title text-sm-center"><?php echo $task->t_code; ?> - Task History</h5>
        </div>
        <div class="card-body" style="background-color: white; ">

          <div class="row">

            <div class="col-lg-3 rounded  p-4" style="border-right: 2px solid; background: #19385b; ; color: white;">
            <div class="row ">  
                <h2 class="text-sm-center text-primary ">Task Details </h2>  
               
            </div>
              <div class="row "> 
                     <h6 class=" m-1">Task Code : </h6>  
                     <p class="card-text mx-1 text-warning"><?php echo $task->t_code; ?></p> 
              </div>
              
               <div class="row "> 
                     <h6 class=" m-1">Given By : </h6>  
                     <p class="card-text mx-1 text-warning"><?php echo $task->given; ?></p> 
              </div>
              <div class="row ">  
                <h6 class="m-1">Follow Up :</h6>  
                <p class="card-text mx-2 text-warning"><?php echo $task->follow; ?></p>
               </div>
                <div class="row "> 
                     <h6 class=" m-1">Start Date : </h6>  
                     <p class="card-text mx-1 text-warning"><?php echo $task->start_date; ?></p> 
              </div>
              <div class="row ">  
                <h6 class="m-1">End Date :</h6>  
                <p class="card-text mx-2 text-warning"><?php echo $task->end_date; ?></p>
               </div>
                <div class="row ">  
                <h6 class="m-1">Task Title :</h6>  
                <p class="card-text mx-2 text-warning"><?php echo $task->t_title; ?></p>
               </div>
                <div class="row ">
              <h6 class=" m-1 ">Task  Description :</h6>
              <div class="col-md-12">
                <p class=" card-text text-warning"><?php echo $task->t_description; ?></p>
              </div>
             </div>
             <div class="row">
               <h6 class=" m-1 ">Task Files:</h6>
               <div class="col-md-12">
               <?php
                if( !empty( $task_files ) ) {
                  echo '<ul style="padding-left:0px;list-style: none;">';
                  foreach ( $task_files as $file) {
                    ?>
                    <li>
                    <a href="<?php echo $file["url"]; ?>" target="_blank">
                      <img src="https://freeiconshop.com/wp-content/uploads/edd/document-download-flat.png"  width="40" height="40"> <?php echo $file["f_title"]; ?>
                    </a>
                    </li>
                    <?php
                  }
                  echo '</ul>';
                } else {
                  echo 'No Files Available';
                }
                ?>
                </div>
             </div>
              <!--  <a href="http://gdlp01.c-wss.com/gds/0/0300004730/02/eosrt3-eos1100d-im2-c-en.pdf" download>
                            <img src="https://freeiconshop.com/wp-content/uploads/edd/document-download-flat.png"  width="40" height="40"> Download File</a> -->

            </div>

            <div class="col-lg-9 rounded  p-4 table-striped">
              
                 



                <div class="row font-weight-bold text-danger border">                                          
                  <div class="col-md-2"><label>Date</label></div>
                  <div class="col-md-7"><label>Update</label></div>
                  <div class="col-md-2"><label>Files</label></div>
                  <div class="col-md-1"><label>Status</label></div>
                </div>   

                  <?php
                    if (!empty($taskHistory)){
                      echo '<div class="overflow-auto">';
                      foreach ($taskHistory as $key => $value) 
                      {
                        $newDate = date("d-M-y", strtotime($value->created_at));
                        echo '<div class="row    bg-light  border-bottom ">';
                        echo '<div class="col-md-2 text-info font-weight-bold border-right pt-5 ">'.$newDate.'</div>';
                        echo '<div class="col-md-7 bg-light p-3 border-right ">'.$value->berfore.'</br><hr>'.$value->after.'</div>';
                        echo '<div class="col-md-2 bg-light p-3 border-right ">';
                        if( !empty( $value->files ) ) {
                          echo '<ul style="padding-left:0px;list-style: none;">';
                          foreach ( $value->files as $file) {
                            ?>
                            <li>
                            <a href="<?php echo $file["url"]; ?>" target="_blank">
                              <img src="https://freeiconshop.com/wp-content/uploads/edd/document-download-flat.png"  width="40" height="40"> <?php echo $file["f_title"]; ?>
                            </a>
                            </li>
                            <?php
                          }
                          echo '</ul>';
                        } else {
                          echo 'No Files Available';
                        }
                        echo '</div>';
                        echo '<div class="col-md-1 text-primary t-3 text-sm-center  pt-5"><label><b>'.$value->status.'</b></label></div>';
                        echo '</div>';
                      }
                      echo '</div>';
                    } else {
                        ?>
                            <div class="col-md-6 offset-3">
                                <br>
                                <div class="alert alert-primary">
								<span>
									<b> Sorry!</b> No task history is available right now.
								</span>
                                </div>
                            </div>
                        <?php
                    }

                  ?>


            </div>

         </div>
<!--
         <div class="row" style=" background-color: white; ">
           <div class="col-lg-12 m-4">
             <h6 class="card-subtitle mb-2 ">Title </h6>
             <p class="card-text"><?php echo $task->t_title; ?></p>
             <h6 class="card-subtitle mb-2 ">Task  Description</h6>
             <p class="card-text"><?php echo $task->t_description; ?></p>
             <a href="http://gdlp01.c-wss.com/gds/0/0300004730/02/eosrt3-eos1100d-im2-c-en.pdf" download>
              <img src="https://freeiconshop.com/wp-content/uploads/edd/document-download-flat.png"  width="40" height="40"> View attachement</a>
            </div>
          </div>
-->

<!--

                <div class="well">
                  <h2 class="text-divider"></h2>
                </div>
-->
        
                <!-- <div class="well">
                  <h4 class="text-divider"><span>Update Task Form</span></h4>
                </div>



                <div class="row">                                          
                  <div class="col-md-2"><label>Date</label></div>
                  <div class="col-md-8"><label>Update</label></div>
                  <div class="col-md-2"><label>Status</label></div>
                </div>    -->

                  <?php
                    /*if (!empty($taskHistory)){
                      foreach ($taskHistory as $key => $value) 
                      {
                        $newDate = date("d-M-y", strtotime($value->created_at));
                        echo '<div class="row">';
                        echo '<div class="col-md-2">'.$newDate.'</div>';
                        echo '<div class="col-md-8">'.$value->berfore.'</br>'.$value->after.'</div>';
                        echo '<div class="col-md-2"><label>'.$value->status.'</label></div>';
                        echo '</div>';
                      }
                    }*/

                  ?>

        </div>

      </div>

    </div>



  </div>

</div>
</div>
      <!-- Dashboard for User body-->