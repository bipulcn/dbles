<div class="col-12 schemalst">
    <div class="row">
        <div class="col-2 bg55">
            <h6 class="py-3 px-1 hrb" style="background: var(--b5); ">Schema Title</h6>
            <h6 class="link" ng-repeat="(k, v) in schema" ng-click='selectSchema1(k)'>{{k}}</h6>
        </div>
        <div class="col-10">
            <h6 class="py-3 px-1 hrb" style="background: var(--b5); ">Schema Relation</h6>
            <div class="row" ng-repeat="(y, s) in schema[selSchema1].data">
                <div class="col-2 link"><label><input type="checkbox" ng-model="tableCheck[y]">
                        <b>{{s.tname}}:</b></label></div>
                <div class="col-10 link">
                    (<i ng-repeat='(k, t) in s.more'><i ng-if='s.key[k]'
                            style="color:var(--c12); text-decoration:underline;">{{t}}</i><i ng-if='!s.key[k]'
                            ng-class='{fkclass : checkFK(t)}'>{{t}}</i><i ng-if="k<s.more.length-1">, </i></i>)
                </div>
            </div>
            <!-- <div ng-show='selSchema1'>
                    <select ng-model='reqTable' class="smallOption">
                  <option  ng-repeat="(k, v) in problemlist" value="{{k}}">{{v.title}}</option>
                </select>
                <button class="btn btn-primary" ng-click='addForProblem(reqTable, selSchema1)'>Add Table</button></div> -->
            <hr class="hr_mi">
        </div>
    </div>
</div>
<div class="col-12 schemalst">
    <div class="row">
        <div class="col-2 bg65">
            <h6 class="col hrb" style="background: var(--b5); ">Schema Title</h6>
            <h6 class="link" ng-repeat="(k, v) in schema" ng-click='selectSchema2(k)'>{{k}}</h6>
            <!--  -->
        </div>
        <div class="col-2 bg55">
            <h6 class="col hrb" style="background: var(--b5); ">Tables</h6>
            <div class="link" ng-repeat="(y, s) in schema[selSchema2].data" ng-click="loadTableInfo(s.tname)">
                {{s.tname}}</div>
            <hr class="hr_mi">
        </div>
        <div class="col-8 bg65">
            <h6 class="col hrb" style="background: var(--b5); ">Details</h6>
            <div class="col">{{schema[selSchema].detail}}</div>
            <div class="col">
                <table class="dbtable">
                    <tr>
                        <th ng-repeat="(k, v) in tableInfos.field"><b>{{v}}</b></th>
                    </tr>
                    <tr ng-repeat="(s, d) in tableInfos.data">
                        <td ng-repeat="(k, v) in tableInfos.field">{{d[v]}}</td>
                    </tr>
                </table>
                <hr class="hr_mi">
            </div>
        </div>
    </div>
</div>