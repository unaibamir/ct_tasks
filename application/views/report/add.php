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
          <h5 class="title text-sm-center"><?php echo $task->t_code; ?> - Task Form</h5>
        </div>
        <div class="card-body" style="">

          <?php


/*
[tid] => 2
    [t_title] => Task2
    [t_code] => 3179
    [department_id] => 2
    [parent_id] => 2
    [assignee] => 4
    [reporter] => 5
    [t_status] => 
    [attachment_id] => 0
    [t_description] => ASDFASASFDS
    [t_created_at] => 2019-10-06 06:00:03
    [t_updated_at] => 2019-10-06 06:00:03
    [start_date] => 2019-10-07 00:00:00
    [end_date] => 2019-10-17
    [created_by] => 3
    [c_name] => Marketing*/
    ?>



    <div class="row  m-1">
        <div class="col-lg-2 rounded p-4 " style="border-right: 2px solid; background: #02300a;  color: white;">
              <div class="row ">  
                <h3 class="text-sm-center text-primary ">Employee Record </h3>  
               
               </div>
              <div class="row text-sm-center "> 
                     <h6 class=" m-1">First Name : </h6>  
                    <p class="card-text mx-1 text-warning"><?php echo $currentUser->first_name; ?></p> 
              </div>
              <div class="row ">  
                <h6 class="m-1">Last Name :</h6>  
                <p class="card-text mx-2 text-warning"><?php echo $currentUser->last_name; ?></p>
               </div>
                <div class="row "> 
                     <h6 class=" m-1">Employee Code : </h6>  
                     <p class="card-text mx-1 text-warning"><?php echo $currentUser->username; ?></p> 
              </div>
              
             
      </div>
       <div class="col-lg-3 rounded  p-4" style="border-right: 2px solid; background: #19385b; ; color: white;">
            <div class="row ">  
                <h2 class="text-sm-center text-primary ">Task Details </h2>  
               
            </div>
              <div class="row "> 
                     <h6 class=" m-1">Task Code : </h6>  
                     <p class="card-text mx-1 text-warning"><?php echo $task->t_code; ?></p> 
              </div>
              
               <div class="row "> 
                     <h6 class=" m-1">Given: </h6>
                     <p class="card-text mx-1 text-warning"><?php echo $task->given; ?></p> 
              </div>
              <div class="row ">  
                <h6 class="m-1">Reporter:</h6>
                <p class="card-text mx-2 text-warning"><?php echo $task->follow; ?></p>
               </div>
               <div class="row ">
                   <h6 class="m-1">Employee:</h6>
                   <p class="card-text mx-2 text-warning">
                       <?php echo $currentUser->first_name; ?> <?php echo $currentUser->last_name; ?>
                   </p>
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
              <p class=" card-text m-2 text-warning"><?php echo $task->t_description; ?></p>
             </div>

      </div>
      <div class="col-lg-6 rounded p-4" style="border-right: 2px solid; background: #19385b; ; color: white;">
                <h3 class="text-divider text-primary"><span>Submit Task form</span></h4>
           <?php
          $currentdate = mktime(0,0,0,date("m"),date("d"),date("Y"));
          echo ' <label class="text-warning font-weight-bold " >Current Date: </label> '.date("d / m / Y", $currentdate) .'<br>';

          echo '<label class="text-warning font-weight-bold " >Current Month : </label> '.date(" F Y").'   '?>

           <?php echo form_open('report/save', array('id'=>'report_form'));?>

               <div class="row">
    
<?php
$disabled = '';
$placeholderAfter = $placeholder = 'Add Comment Here... ';
if (!empty($alreadReported->berfore))
{
  $disabled = 'disabled';
  $placeholder = $alreadReported->berfore;
}
if (!empty($alreadReported->after))
{
  $disabled = 'disabled';
  $placeholderAfter = $alreadReported->after;
}

$status = 0;
if (!empty($alreadReported->status))
{
  $status = $alreadReported->status;
}

?>

             <div class="col-md-10">
                <span class="text-warning"><b>Befor Break  </span>
                 <div class="input-group-prepend">

                   <textarea name="befor" class="col-md-12" aria-label="With textarea" rows="5" placeholder=" <?=$placeholder?>" <?=$disabled?>></textarea>
             </div>

               <span class="text-warning"><b>After Break  </span>
            <div class="input-group-prepend  ">

                <textarea name="after" class="col-md-12" aria-label="With textarea" rows="5" placeholder=" <?=$placeholderAfter?>" <?=$disabled?>></textarea>
              </div>
            </div>




         <div class="col-md-2 m-4 ">
           <p></p>
           
               <div class="">
                   <label class="form-check-label text-warning" for="inlineRadio1"> 
                    <input class="form-check-input" type="radio" name="status" id="inlineRadio1" value="Y" <?=$disabled?> <?=($status =='Y')? 'checked': '';?> />Y
                  </label>
                </div>
                <div class="">
                 
                  <label class="form-check-label text-warning" for="inlineRadio1"> 
                    <input class="form-check-input" type="radio" name="status" id="inlineRadio1" value="N" <?=$disabled?> <?=($status =='N')? 'checked': '';?> />N</label>
                 </div>

                
               <div class="">
               
                <label class="form-check-label text-warning" for="inlineRadio1"> 
                  <input class="form-check-input " type="radio" name="status" id="inlineRadio1" value="H" <?=$disabled?> <?=($status =='H')? 'checked': '';?> />H
                </label>
              </div>

               <div class="">
                <label class="form-check-label text-warning" for="inlineRadio1">  
                  <input class="form-check-input" type="radio" name="status" id="inlineRadio1" value="C" <?=$disabled?> <?=($status =='C')? 'checked': '';?> />C
                </label>
              </div>
          </div>

  </div>
      <div class="row">
          <div class="col-md-8">
            <div class="input-group-prepend">
              <span class="text-warning m-2" id="inputGroupFileAddon01">Upload File</span>
            </div>
            <div class="custom-file">
              <input type="file" class="custom-file-input" id="inputGroupFile01"
              aria-describedby="inputGroupFileAddon01" <?=$disabled?>>
              <label class="custom-file-label " for="inputGroupFile01">Choose file</label>
            </div>
        </div>
        <div class="col-md-3 mt-4">
              <input type="hidden" name="task_id" value="<?php echo $task->tid; ?>" />
              <input type="submit" class="btn btn-info   " value="Save" <?=$disabled?> />

        </div>
       
        <?php echo form_close();?>



         <!-- Form End here-->



          <!--
                <div class="list-group">
               
                 <?php echo '<a href="'.base_url('task/alert/'.$task->tid).'" class="list-group-item list-group-item-action list-group-item-secondary text-sm-center">View Task List</a> '; ?>
                 <?php echo ' <a href="'.base_url('report/history/'.$task->tid).'" class="list-group-item list-group-item-action list-group-item-success text-sm-center">Task History '; ?></a>
               
                </div>
          -->
      </div>

<!--
     <div class="col-lg-4 rounded" style="border-right: 2px solid; background: #19385b; text-align: center; color: white;">
       <p class="card-title"><h6>Given By </h6>  <?php echo $task->given; ?></b></p>
       <p class="card-title"><h6>Follow up </h6>  <?php echo $task->follow; ?></b></p>       
     </div>


    <div class="col-lg-4 rounded" style="border-right: 2px solid; background: #19385b; text-align: center; color: white;">
       <p class="card-title"><h6> Start Date</h6>  <?php echo $task->start_date; ?></b></p>
       <p class="card-title success"><h6>End Date </h6>  <?php echo $task->end_date; ?></b></p>
     </div>


-->
   </div>


<!--
   <div class="row m-4" style=" ">
     <div class="col-lg-6 ">
       <h6 class="card-subtitle mb-2 ">Task Title </h6>
       <p class="card-text m-3"><?php echo $task->t_title; ?></p>
       <h6 class="card-subtitle mb-2 ">Task  Description</h6>
       <p class="card-text m-3"><?php echo $task->t_description; ?></p>
      
      </div>
      <div class="col-lg-6 "> <a href="http://gdlp01.c-wss.com/gds/0/0300004730/02/eosrt3-eos1100d-im2-c-en.pdf" download>
        <img src="https://freeiconshop.com/wp-content/uploads/edd/document-download-flat.png"  width="40" height="40"> View attachement</a></div>
    </div>

-->

<!--
    <div class="well">
      <h2 class="text-divider"></h2>
    </div>


    <div class="well">
      <h4 class="text-divider"><span>Update Task form</span></h4>

    </div>
-->
   <!-- <?php echo form_open('report/save', array('id'=>'report_form'));?> 


    <div class="row">                                          

      <div class="col-md-8">
        <span class=""><b>Befor Break  </span>
          <div class="input-group-prepend">

            <textarea name="befor" class="col-md-12" aria-label="With textarea" rows="5" placeholder=" Add Comment Here... "></textarea>
         </div>

         <span class=""><b>After Break  </span>
           <div class="input-group-prepend  ">

             <textarea name="after" class="col-md-12" aria-label="With textarea" rows="5" placeholder=" Add Comment Here... "></textarea>
           </div>
         </div>


         <div class="col-md-4 mt-4">
           <span class="" id="inputGroupFileAddon01">SELECT</span>
           <div class="col-md-6">
            <input class="form-check-input" type="radio" name="status" id="inlineRadio1" value="Y">
            <label class="form-check-label" for="inlineRadio1">Y</label>


            <input class="form-check-input" type="radio" name="status" id="inlineRadio1" value="N">
            <label class="form-check-label" for="inlineRadio1">N</label>


            <input class="form-check-input" type="radio" name="status" id="inlineRadio1" value="H">
            <label class="form-check-label" for="inlineRadio1">H</label>


            <input class="form-check-input" type="radio" name="status" id="inlineRadio1" value="C">
            <label class="form-check-label" for="inlineRadio1">C</label>
          </div>

        </div>   


        <div class="">
          <div class="input-group-prepend">
            <span class="" id="inputGroupFileAddon01">Upload File</span>
          </div>
          <div class="custom-file">
            <input type="file" class="custom-file-input" id="inputGroupFile01"
            aria-describedby="inputGroupFileAddon01">
            <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
          </div>
        </div>
        <input type="hidden" name="task_id" value="<?php echo $task->tid; ?>" />
        <input type="submit" class="btn btn-info right" value="Save" style="background: #244973;">


      </div>

      <?php echo form_close();?>
    -->
    </div>

  </div>



</div>

</div>
</div>
      <!-- Dashboard for User body-->