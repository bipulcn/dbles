<div class="row" ng-repeat="(k, v) in problemlist">
    <div class='col-12 col'>
        <hr class="hr_mi">
        <h3 ng-init="probindex[v.pid]=$index+1">{{$index+1}}. {{v.title}}</h3>
        <div>{{v.details}}</div>
    </div>
    <div class="col-12 col bg55">
        <div ng-repeat="(rk, rv) in problemrefe[k]">
            <div class="row" ng-repeat="(y, s) in schema[rv.schema].data" ng-if="y==rv.table">
                <div class="col-1"><b>{{s.tname}}:</b></div>
                <div class="col-10">(<i ng-repeat='(k, t) in s.more'><i ng-if='s.key[k]' style="color:var(--c12); text-decoration:underline;">{{t}}</i><i ng-if='!s.key[k]' ng-class='{fkclass : checkFK(t)}'>{{t}}</i><i ng-if="k<s.more.length-1">, </i></i>) </div>
                <!-- <div class="col-1"><button class="btn btn-warning" ng-click='removeRefer(k, rv.schema, rv.table)'> remove </button></div> -->
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="baseProblem">
            <h5 class="col">Code</h5>
            <div class="row">
                <div class="col-7 col">
                    <textarea name="name" class="sql_cod_box" ng-model='mod_query_code[k]' ng-keypress="shortcutKey($event, k)" ng-init="mod_query_code[k]=v.codes" ng-change='analyzeStatement(mod_query_code[k])'></textarea>
                </div>
                <div class="col-5 col">
                    <hr class="hr_mx">
                    <button class="btn btn-primary" ng-click="executeQuery(k)">Run</button>
                    <!-- <button class="btn btn-primary" ng-click="loadResults(v.solution, k)">Load Result</button> -->
                    <button class="btn btn-primary" ng-click="saveUserAnswer(v.pid, mod_query_code[k])">Save
                        Answer</button>
                </div>
            </div>
            <div class="row">
                <div class="col-10 output">
                    <h6>Output</h6>
                    <div class="outputContent">
                        <table class="dbtable">
                            <tr>
                                <th ng-repeat='dv in outputTab[k].field'>{{dv}}</th>
                            </tr>
                            <tr ng-repeat='dv in outputTab[k].data'>
                                <td ng-repeat='df in outputTab[k].field'>{{dv[df]}}</td>
                            </tr>
                        </table>
                        <div class="error" ng-bind-html="queryError[k]"></div>
                    </div>
                </div>
            </div>
            <hr class="hr_mx">
        </div>
    </div>
</div>