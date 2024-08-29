<div class="row" ng-repeat="(k, v) in problemlist">
    <div class='col-12 link border py-3 my-2' ng-click='showSectionEnb(v.data.pid, k)'>
        <hr class="arrow ar-right" ng-show='!showSection[k]'>
        <!-- <hr class="arrow ar-left" ng-show='showSection[k]'> -->
        <hr class="arrow5 ar-bottom" ng-show='showSection[k]'>
        <h3 class="m-0 pt-0" ng-init="probindex[v.data.pid]=$index+1">{{$index+1}}. {{v.data.title}}</h3>
        <div class="px-3">{{v.data.details}}</div>
    </div>
    <div class="col-12 bg55">
        <div ng-repeat="(rk, rv) in problemrefe[k]">
            <div class="row" ng-repeat="(y, s) in schema[rv.schema].data" ng-if="y==rv.table">
                <div class="col-1"><b>{{s.tname}}:</b></div>
                <div class="col-10">(<i ng-repeat='(k, t) in s.more'><i ng-if='s.key[k]' style="color:var(--c12); text-decoration:underline;">{{t}}</i><i ng-if='!s.key[k]' ng-class='{fkclass : checkFK(t)}'>{{t}}</i><i ng-if="k<s.more.length-1">, </i></i>) </div>
                <!-- <div class="col-1"><button class="btn btn-warning" ng-click='removeRefer(k, rv.schema, rv.table)'> remove </button></div> -->
            </div>
        </div>
    </div>
    <div class="col-12" ng-show='showSection[k]'>
        <div class="mb-3">
            <h5 class="">Code</h5>
            <div class="row">
                <div class="col-10">
                    <textarea name="name" class="sql_cod_box" ng-model='mod_query_code[k]' ng-keypress="shortcutKey($event, k)" ng-change='analyzeStatement(mod_query_code[k])'></textarea>
                </div>
                <div class="col-2">
                    <div class="text-center">
                        <button class="btn btn-primary mb-2" ng-click="executeQuery(k)">Run</button>
                        <button class="btn btn-primary mb-2" ng-click="loadAnswer(v.data.solution, k)" ng-show="v.data.senb=='T'">View Solution</button>
                        <button class="btn btn-primary mb-2" ng-click="loadResults(v.data.solution, k)">Load
                            Result</button>
                        <button class="btn btn-primary mb-2" ng-click="saveUserAnswer(v.data.pid, 0, mod_query_code[k])">Save Answer</button>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <h6 class="bg-primary bg-opacity-50 px-3 rounded-top text-white mb-0">Output</h6>
                    <div class="border border-primary border-top-0 rounded-bottom bg-primary bg-opacity-10" style='min-height: 100px;'>
                        <div class="table-responsive" style='min-height: 100px; max-height: 300px;'>
                            <table class="table table-sm table-secondary table-bordered border-secondary bg-none">
                                <tr>
                                    <th ng-repeat='dv in outputTab[k].field'>{{dv}}</th>
                                </tr>
                                <tr ng-repeat='dv in outputTab[k].data'>
                                    <td ng-repeat='df in outputTab[k].field'>{{dv[df]}}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="error" ng-bind-html="queryError[k]"></div>
                    </div>
                </div>
                <div class="col-6">
                    <h6 class="bg-primary bg-opacity-50 px-3 rounded-top text-white mb-0">Results</h6>
                    <div class="border border-primary border-top-0 rounded-bottom bg-primary bg-opacity-10" style='min-height: 100px;'>
                        <div class="table-responsive" style='min-height: 100px; max-height: 300px;'>
                            <table class="table table-sm table-secondary table-bordered border-secondary bg-none">
                                <tr>
                                    <th ng-repeat='dv in descTab[k].field'>{{dv}}</th>
                                </tr>
                                <tr ng-repeat='dv in descTab[k].data'>
                                    <td ng-repeat='df in descTab[k].field'>{{dv[df]}}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="error" ng-bind-html="descError[k]"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mb-3 px-3">
            <div ng-repeat="(s, d) in v.same">
                <div class="row mb-3">
                    <div class="col-12 link border rounded bt-3" ng-click='showSubSectionEnb(d.pid, k, s)'>
                        <h6>Practice: <b>{{probindex[d.pid]}}.{{$index+1}}</b></h6>
                        {{d.details}}
                    </div>
                    <h5 class="col-12" ng-show='showSubSection[k][s]'>Code</h5>
                    <div class="col-10" ng-show='showSubSection[k][s]'>
                        <textarea name="name" class="sql_cod_box" ng-model='mod_same_query_code[k][s]' ng-keypress="shortcutKey($event, k, s)" ng-init="mod_same_query_code[k][s]=d.answer" ng-change='analyzeStatement(mod_query_code[k])'></textarea>
                    </div>
                    <div class="col-2" ng-show='showSubSection[k][s]'>
                        <button class="btn btn-primary mb-2" ng-click="executeQuery(k, s)">Run</button>
                        <button class="btn btn-primary mb-2" ng-click="loadAnswer(d.solution, k, s)" ng-show="d.senb=='T'">View Solution</button>
                        <button class="btn btn-primary mb-2" ng-click="loadResults(d.solution, k, s)">Load Result</button>
                        <button class="btn btn-primary mb-2" ng-click="saveUserAnswer(d.pid, d.spid, mod_same_query_code[k][s])">Save Answer</button>
                    </div>
                    <div class="col-6 output" ng-show='showSubSection[k][s]'>
                        <h6 class="bg-primary bg-opacity-50 px-3 rounded-top text-white mb-0">Output</h6>
                        <div class="border border-primary border-top-0 rounded-bottom bg-primary bg-opacity-10" style='min-height: 100px;'>
                            <div class="table-responsive" style='min-height: 100px; max-height: 300px;'>
                                <table class="table table-sm table-secondary table-bordered border-secondary bg-none">
                                    <tr>
                                        <th ng-repeat='dv in outputSameTab[k][s].field'>{{dv}}</th>
                                    </tr>
                                    <tr ng-repeat='dv in outputSameTab[k][s].data'>
                                        <td ng-repeat='df in outputSameTab[k][s].field'>{{dv[df]}}</td>
                                    </tr>
                                </table>
                                <div class="error" ng-bind-html="querySameError[k][s]"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 output" ng-show='showSubSection[k][s]'>
                        <h6 class="bg-primary bg-opacity-50 px-3 rounded-top text-white mb-0">Results</h6>
                        <div class="border border-primary border-top-0 rounded-bottom bg-primary bg-opacity-10" style='min-height: 100px;'>
                            <div class="table-responsive" style='min-height: 100px; max-height: 300px;'>
                                <table class="table table-sm table-secondary table-bordered border-secondary bg-none">
                                    <tr>
                                        <th ng-repeat='dv in descSameTab[k][s].field'>{{dv}}</th>
                                    </tr>
                                    <tr ng-repeat='dv in descSameTab[k][s].data'>
                                        <td ng-repeat='df in descSameTab[k][s].field'>{{dv[df]}}</td>
                                    </tr>
                                </table>
                                <div class="error" ng-bind-html="descSameError[k][s]"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>