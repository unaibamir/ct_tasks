<?php defined('BASEPATH') OR exit('No direct script access allowed');  ?>



<!-- Star of dashboard -->
<div class="panel-header panel-header-lg Center" style="text-align: center;">
  <!-- <canvas id="bigDashboardChart"></canvas> -->
 <a class="navbar-brand " href="">Task Assignment System <h3 class="display-1">Manager - Panel</h3></a>
</div>
<div class="content">
  <div class="row">
    <div class="col-lg-4">
      <div class="card card-chart">
        <div class="card-body">
          <div class="chart-area">
            <canvas id="lineChartExample"></canvas>
          </div>
        </div>

      </div>
    </div>
    <div class="col-lg-4 col-md-6">
      <div class="card card-chart">

        <div class="card-body">
          <div class="chart-area">
            <canvas id="lineChartExampleWithNumbersAndGrid"></canvas>
          </div>
        </div>

      </div>
    </div>
    <div class="col-lg-4 col-md-6">
      <div class="card card-chart">

        <div class="card-body " >
          <div class="chart-area">
            <i class="now-ui-icons"></i>

          </div>
        </div>

      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-6">
      <div class="card  card-tasks">

        <div class="card-body ">
          <div class="table-full-width table-responsive">

          </div>
        </div>

      </div>
    </div>
    <div class="col-md-6">
      <div class="card">

        <div class="card-body">
          <div class="table-responsive">
          </div>
        </div>
      </div>
    </div>
  </div>


  <!-- ADD NEW TASK ROW END HERE -->
  <div class="row" > 

    <div class="col-md-12" >
      <div class="card">
        <div class="card-header">
          <h5 class="title">Add New Task</h5>
        </div>
        <div class="card-body" >
          <!-- Form Start her-->
          <form>
            <div class="row" >
             <div class="col-md-6 pr-1">
              <div class="form-group">
                <label>Task Title</label>
                <input type="text" class="form-control" placeholder="Add Title" value="">
              </div>
            </div>
            <div class="col-md-6 pr-1">
              <div class="form-group">
                <label>Task Code</label>
                <input type="text" class="form-control" placeholder="Add Title" value="">
              </div>
            </div>
          </div>


          <div class="row">
            <div class="col-md-4 pr-1">
              <div class="form-group">
                <label for="sel1">Select Department</label>
                <select class="form-control" id="sel1">
                  <option>Management</option>
                  <option>Finance</option>
                  <option>Sales</option>
                  <option>Human Resources</option>
                  <option>IT Department</option>
                </select>
              </div>  
            </div>
            <div class="col-md-4 pr-1">
              <div class="form-group">
                <label for="sel1">Select Project</label>
                <select class="form-control" id="sel1">
                  <option>Oil & Gas Project</option>
                  <option>Finance Sector</option>
                  <option>Project 3</option>
                  <option>Project 4</option>
                  <option>Project 5t</option>
                </select>
              </div>  
            </div>
            <div class="col-md-4 pr-1">
              <div class="form-group">
                <label for="sel1">Select Department</label>
                <select class="form-control" id="sel1">
                  <option>Management</option>
                  <option>Finance</option>
                  <option>Sales</option>
                  <option>Human Resources</option>
                  <option>IT Department</option>
                </select>
              </div>  
            </div>
          </div>


          <div class="row">
            <div class="col-md-6 pr-1">
              <div class="form-group">
                <label for="sel1">Given Person</label>
                <select class="form-control" id="sel1">
                  <option>Abdul Aziz</option>
                  <option>Hussain Al Mulla</option>
                  <option>Muraleedharan</option>
                  <option>Human Resources</option>
                  <option>IT Department</option>
                </select>
              </div>  
            </div>
            <div class="col-md-6 pr-1">
              <div class="form-group">
                <label for="sel1">Follow Up</label>
                <select class="form-control" id="sel1">
                  <option>Lisa</option>
                  <option>Zeeshan</option>
                  <option>Junaid</option>
                  <option>other</option>
                </select>
              </div>  
            </div>  
          </div>

          <div class="row">

            <div class="col-md-6 pr-1">
              <div class="form-group">
               <label >Start Date</label>
               <input type="date" name="bday" max="3000-12-31" min="1000-01-01" class="form-control">
             </div>
           </div>

           <div class="col-md-6 pl-1">
             <div class="form-group">
              <label >End Date</label>
              <input type="date" name="bday" min="1000-01-01" max="3000-12-31" class="form-control">
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-9">
            <div class="form-group">
              <label>Task Description</label>
              <textarea class="form-control" rows="5" id="comment" placeholder="Add Task description here" style="border: 1px solid #e3e3e3;"></textarea>
            </div>
          </div>
          <div class="col-md-2 file-upload-wrapper">
            <label>Attach File</label>
            <input type="file" id="input-file-now" class="file-upload" />
          </div>
        </div>

        <input type="submit" class="btn btn-info btn-lg pull-right" value="Submit" style="background: #244973;">
      </form>
      <!-- Form End here-->
    </div>
  </div>
</div>
</div>

<!-- ADD NEW TASK ROW START HERE -->

</div>