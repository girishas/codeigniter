<?php $this->load->view('admin/common/header'); ?>
<body class="animsition app-contacts page-aside-left">
  <!--[if lt IE 8]>
  <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
  <![endif]-->
  <?php $this->load->view('admin/common/navbar'); ?>
  <?php $this->load->view('admin/common/left_menubar'); ?>
  <!-- Page -->
  <div class="page">
    
    <!-- Contacts Content -->
    <div class="page-main">
      <div class="page-content">
        <div class="panel">
      <!-- Contacts Content Header -->
      <div class="page-header">
        <h1 class="page-title">All Service Groups</h1>
        <div class="page-header-actions"><a href="<?php echo base_url('admin/service/add_service_group');?>"><button type="button" class="btn btn-block btn-primary">Add Service Group</button></a></div>
      </div>
      <!-- Contacts Content -->
      <div id="contactsContent" class="page-content page-content-table" data-plugin="selectable">
        <!-- Actions -->
        <div class="page-content-actions">
          <div class="float-right">
            <form>
              <div class="input-search input-search-dark">
                <i class="input-search-icon md-search" aria-hidden="true"></i>
                <input type="text" class="form-control" name="" placeholder="Search...">
              </div>
            </form>
          </div>
          <div class="btn-group btn-group-flat">
            <div class="dropdown">
              Records
              <select class="select-style" style="width:65px;">
                <option>10</option>
                <option>25</option>
                <option>50</option>
                <option>100</option>
                <option>All</option>
              </select> per page
            </div>
            
          </div>
        </div>
        <!-- Contacts -->
        <table class="table is-indent" data-plugin="animateList" data-animate="fade" data-child="tr"
          data-selectable="selectable">
          <thead>
            <tr>
              <th class="pre-cell dark-background-heading"></th>
              <th scope="col" class="dark-background-heading">
                <span class="checkbox-custom checkbox-primary checkbox-lg contacts-select-all">
                  <input type="checkbox" class="contacts-checkbox selectable-all" id="select_all"
                  />
                  <label for="select_all"></label>
                </span>
              </th>
              <th class="cell-100 dark-background-heading" scope="col">Group Name</th>
              <th class="cell-100 dark-background-heading" scope="col">Added date</th>
              <th class="cell-30 dark-background-heading" scope="col">Status</th>
              <th class="cell-30 dark-background-heading" scope="col">Treatment Type</th>
              <th class="cell-50 dark-background-heading" scope="col">
                <div class="btn-group dropdown">
                  <button type="button" class="btn btn-default dropdown-toggle" id="exampleColorDropdown1" data-toggle="dropdown" aria-expanded="false">Actions</button>
                  <div class="dropdown-menu bullet" aria-labelledby="exampleBulletDropdown1" role="menu">
                    <a class="dropdown-item" href="javascript:void(0)" role="menuitem"><i class="icon md-plus" aria-hidden="true"></i>Add New</a>
                    <a class="dropdown-item" href="javascript:void(0)" role="menuitem"><i class="icon md-check" aria-hidden="true"></i>Active All</a>
                    <a class="dropdown-item" href="javascript:void(0)" role="menuitem"><i class="icon md-pause" aria-hidden="true"></i>Inactive All</a>
                    <a class="dropdown-item" href="javascript:void(0)" role="menuitem"><i class="icon md-delete" aria-hidden="true"></i>Delete All</a>
                  </div>
                </div>
              </th>
              <th class="suf-cell"></th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="pre-cell"></td>
              <td class="cell-30">
                <span class="checkbox-custom checkbox-primary checkbox-lg">
                  <input type="checkbox" class="contacts-checkbox selectable-item" id="contacts_1"
                  />
                  <label for="contacts_1"></label>
                </span>
              </td>
              <td class="cell-100">Hair</td>
              <td class="cell-100">2018-04-22 20:42:03</td>
              <td class="cell-30" scope="col"><span class="badge badge-primary">Active</span></td>
              <td class="cell-30" scope="col"><a href="<?php echo base_url('service/service_treatment_type');?>"><button type="button" class="btn btn-info">Treatments(1)</button></a></td>
              <td class="cell-50" scope="col">
                <div class="btn-group dropdown">
                  <button type="button" class="btn btn-dark dropdown-toggle" id="exampleColorDropdown7" data-toggle="dropdown" aria-expanded="false">Actions</button>
                  <div class="dropdown-menu bullet" aria-labelledby="exampleBulletDropdown1" role="menu">
                    <a class="dropdown-item" href="javascript:void(0)" role="menuitem"><i class="icon md-check" aria-hidden="true"></i>Active</a>
                    <a class="dropdown-item" href="javascript:void(0)" role="menuitem"><i class="icon md-pause" aria-hidden="true"></i>Inactive</a>
                    <a class="dropdown-item" href="javascript:void(0)" role="menuitem"><i class="icon md-edit" aria-hidden="true"></i>Edit</a>
                    <a class="dropdown-item" href="javascript:void(0)" role="menuitem"><i class="icon md-delete" aria-hidden="true"></i>Delete</a>
                  </div>
                </div>
              </td>
              <td class="suf-cell"></td>
            </tr>
            <tr>
              <td class="pre-cell"></td>
              <td class="cell-30">
                <span class="checkbox-custom checkbox-primary checkbox-lg">
                  <input type="checkbox" class="contacts-checkbox selectable-item" id="contacts_2"
                  />
                  <label for="contacts_2"></label>
                </span>
              </td>
              <td class="cell-100">Face</td>
              <td class="cell-100">2018-04-22 20:42:03</td>
              <td class="cell-30" scope="col"><span class="badge badge-primary">Active</span></td>
              <td class="cell-30" scope="col"><a href="<?php echo base_url('service/service_treatment_type');?>"><button type="button" class="btn btn-info">Treatments(5)</button></a></td>
              <td class="cell-50" scope="col">
                <div class="btn-group dropdown">
                  <button type="button" class="btn btn-dark dropdown-toggle" id="exampleColorDropdown7" data-toggle="dropdown" aria-expanded="false">Actions</button>
                  <div class="dropdown-menu bullet" aria-labelledby="exampleBulletDropdown1" role="menu">
                    <a class="dropdown-item" href="javascript:void(0)" role="menuitem"><i class="icon md-check" aria-hidden="true"></i>Active</a>
                    <a class="dropdown-item" href="javascript:void(0)" role="menuitem"><i class="icon md-pause" aria-hidden="true"></i>Inactive</a>
                    <a class="dropdown-item" href="javascript:void(0)" role="menuitem"><i class="icon md-edit" aria-hidden="true"></i>Edit</a>
                    <a class="dropdown-item" href="javascript:void(0)" role="menuitem"><i class="icon md-delete" aria-hidden="true"></i>Delete</a>
                  </div>
                </div>
              </td>
              <td class="suf-cell"></td>
            </tr>
            <tr>
              <td class="pre-cell"></td>
              <td class="cell-30">
                <span class="checkbox-custom checkbox-primary checkbox-lg">
                  <input type="checkbox" class="contacts-checkbox selectable-item" id="contacts_3"
                  />
                  <label for="contacts_3"></label>
                </span>
              </td>
              <td class="cell-100">Body</td>
              <td class="cell-100">2018-04-22 20:42:03</td>
              <td class="cell-30" scope="col"><span class="badge badge-primary">Active</span></td>
              <td class="cell-30" scope="col"><a href="<?php echo base_url('service/service_treatment_type');?>"><button type="button" class="btn btn-info">Treatments(4)</button></a></td>
              <td class="cell-50" scope="col">
                <div class="btn-group dropdown">
                  <button type="button" class="btn btn-dark dropdown-toggle" id="exampleColorDropdown7" data-toggle="dropdown" aria-expanded="false">Actions</button>
                  <div class="dropdown-menu bullet" aria-labelledby="exampleBulletDropdown1" role="menu">
                    <a class="dropdown-item" href="javascript:void(0)" role="menuitem"><i class="icon md-check" aria-hidden="true"></i>Active</a>
                    <a class="dropdown-item" href="javascript:void(0)" role="menuitem"><i class="icon md-pause" aria-hidden="true"></i>Inactive</a>
                    <a class="dropdown-item" href="javascript:void(0)" role="menuitem"><i class="icon md-edit" aria-hidden="true"></i>Edit</a>
                    <a class="dropdown-item" href="javascript:void(0)" role="menuitem"><i class="icon md-delete" aria-hidden="true"></i>Delete</a>
                  </div>
                </div>
              </td>
              <td class="suf-cell"></td>
            </tr>
            
          </tbody>
        </table>
      <ul data-plugin="paginator" data-total="50" data-skin="pagination-gap"></ul>
    </div>
  </div>
</div>
</div>
</div>

<!-- End page -->
<?php $this->load->view('admin/common/footer'); ?>