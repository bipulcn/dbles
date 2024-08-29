<div class="" ng-init='loadSurvey()'>
  <h3>Dashboard</h3>
  <div class="row">
    <div class="col-4">
      <div class="sev_list">
        <h5>Agents</h5>
        <h6>Number of Agents:{{agnLen}}</h6>
        <h6>Number of IPs:{{ipLen}}</h6>
        <div class="" ng-repeat='(k, v) in agnt'>
          {{k}}: {{v}}
        </div>
      </div>
    </div>
    <div class="col-4">
      <div class="sev_list">
        <h5>Users</h5>
        <h6>Number of User: {{numUser}}</h6>
        <h6>Active Time: {{ttTime}}</h6>
        <!-- <ul>
          <li ng-repeat="(k, v) in user">{{k}}</li>
        </ul> -->
      </div>
    </div>
    <div class="col-4">
      <div class="sev_list">
        <h5>Pages</h5>
        <h6>Number of pages: {{numPages}}</h6>
      </div>
    </div>
  </div>
</div>
