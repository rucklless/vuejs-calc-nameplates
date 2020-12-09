<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Калькулятор");
?> 
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://cdn.jsdelivr.net/npm/vue@2.6.10/dist/vue.js"></script>
<style>
    .total-price{
    display: block;
    position: absolute;
    bottom: 0;
    width: 100%;
    text-align: center;
    font-size:40px;
    color:#e0212c;
  }
  .add-poket{
    padding: 0px 20px 20px;
  }
  .card-header .fa-times{
    position: absolute;
    right: 17px;
    top: 22px;    
    font-size:20px;
    cursor:pointer;
  }
  .poket .fa-times{
    top: 16px;
    font-size: 15px;
    right: 10px;
  }
  .card-header {
    position: relative;
  }
  .add-poket .fa-plus{
    color:#155724;
  }     
  .children-card{
    height: 311px;
  }
  .add-poket-plus{
    background-color: rgba(0,0,0,.03);
    display: flex;
    align-items: center;
    justify-content: center;
    cursor:pointer;
  }
  .add-poket-plus:hover{
    background-color: rgba(0,0,0,.1);
  }
  .add-poket-disc {
    display: inline-block;
    text-align: center;
    color: gray;
  }
  .add-poket-disc i{
    font-size:37px;
  }
</style>
<div class="container-fluid" id="app">
    <div class="card mb-3" v-for="(nameplate, index) in nameplates">
        <div class="card-header">
            <h3>Табличка {{index+1}}<i class="fa fa-times" @click="deleteNameplate(index)"></i></h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-4 mb-3">
                    <div class="card children-card">                        
                        <h5 class="card-header">Опции</h5>                        
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="width">Ширина, м</label>
                                        <input type="text" v-model="nameplate.width" class="form-control" id="width" aria-describedby="" placeholder="Ширина">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="height">Длина, м</label>
                                        <input type="text" v-model="nameplate.height" class="form-control" id="height" aria-describedby="" placeholder="Длина">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <legend class="col-form-label">Толщина пвх</legend>
                                    <div class="form-check" v-for="(thick, indexThick) in thickness">
                                        <input class="form-check-input" v-model="nameplate.thickness" type="radio" v-bind:name="'thickness-item'+ indexThick +'-plate'+index" v-bind:id="'thickness-item'+ indexThick +'-plate'+index" v-bind:value=" +thick.val">
                                        <label class="form-check-label" v-bind:for="'thickness-item'+ indexThick +'-plate'+index">
                                            {{thick.name}}
                                        </label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <div class="form-check">
                                            <input class="form-check-input" v-model="nameplate.lamination" type="checkbox" :id="'lamination-plate'+ index">
                                            <label class="form-check-label" :for="'lamination-plate'+ index">
                                                Ламинация
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-check">
                                            <input class="form-check-input" v-model="nameplate.molding" type="checkbox" :id="'molding-plate'+ index">
                                            <label class="form-check-label" :for="'molding-plate'+ index">
                                                Багет
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label :for="'cnt-plate'+ index" class="col-6 col-form-label">Кол-во</label>
                                        <div class="col-6">
                                          <input type="number" v-model="nameplate.count" class="form-control pr-2 pl-2" :id="'cnt-plate'+ index" aria-describedby="" step=1 min=0>
                                        </div>
                                    </div>
                                </div>                                 
                            </div>
                        </div>                        
                    </div>
                </div>
                <div class="col-4 mb-3 poket" v-for="(poket, indexP) in nameplate.pokets">
                    <div class="card children-card">
                        <h5 class="card-header">Карман {{indexP+1}} <i class="fa fa-times" @click="deletePoket(index, indexP)"></i></h5>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <label class="form-check-label">Размер</label>
                                    <div class="form-check">
                                        <input class="form-check-input" v-model="poket.size" type="radio" v-bind:name="'poketSize-plate'+index+'-pocket'+indexP" v-bind:id="'poketSize-plate'+index+'-pocket'+indexP" value="1" checked>
                                        <label class="form-check-label" :for="'poketSize-plate'+index+'-pocket'+indexP">
                                            A4
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" v-model="poket.size" type="radio" :name="'poketSize-plate'+index+'-pocket'+indexP" :id="'customSize-plate'+index+'-pocket'+indexP" value="2">
                                        <label class="form-check-label" :for="'customSize-plate'+index+'-pocket'+indexP">
                                            Свой размер
                                        </label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="countPocket">Количество</label>
                                        <input type="number" class="form-control" v-model="poket.count" id="countPocket" placeholder="0" step=1>
                                    </div>
                                </div>
                            </div>
                            <div class="row" v-if="showPoketSize(index, indexP)">
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="width-poket">Ширина, м</label>
                                                <input type="text"  v-model="poket.width" class="form-control" id="width-poket" aria-describedby="" placeholder="Ширина">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="height-poket">Длина, м</label>
                                                <input type="text" v-model="poket.height" class="form-control" id="height-poket" aria-describedby="" placeholder="Длина">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-4 mb-3">
                    <div class="card children-card add-poket-plus" @click="addNewPoket(index)">
                        <div class="add-poket-disc">
                            <i class="fa fa-plus-circle"></i><br>
                            Добавить карман
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
        	Табличка: {{nameplate.costArea}} Ламинация {{nameplate.laminationCost}} Карманы {{nameplate.poketsCost}} Итого <span style="color:red; font-size:18px; font-weight:bold;">{{nameplate.totalCost}}</span><br>        	
        </div>
        <div class="error">
            {{nameplate.err}}
        </div>
    </div>

    <button class="add-table btn btn-dark mb-3" @click="addNewNameplate">Добавить табличку <i class="fa fa-plus-circle"></i></button>

    <div class="card-footer text-muted">
        <div class="row">
            <div class="col-6">
                Общая площадь {{totalArea}}
                Стоимость {{totalArea}}
                Стоимость багета {{costMolding}}
                Стоимость площади {{calculating.total}}
            </div>
            <div class="col-6" style="font-size:36px; color:red;">
                {{totalCost}}
            </div>
        </div>
    </div>    
</div>
<script src="script.js"></script>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>