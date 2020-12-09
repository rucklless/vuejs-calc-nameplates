<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Калькулятор");
?>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
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
</style>
<div class="container-fluid" id="app">
    <form>
        <div class="form-row">
            <div class="form-group col-md-2">                
                <fieldset class="form-group col-12">
                    <div class="row">
                        <legend class="col-sm-12">Плотность</legend>
                        <div class="col-sm-10">
                            <div class="form-check">
                                <input v-model.number="density" class="form-check-input" type="radio" name="density" id="density330" value="330">
                                <label class="form-check-label" for="density330">
                                    330
                                </label>
                            </div>
                            <div class="form-check">
                                <input v-model="density" class="form-check-input" type="radio" name="density" id="density440" value="440">
                                <label class="form-check-label" for="density440">
                                    440
                                </label>
                            </div>
                            <div class="form-check">
                                <input v-model="density" class="form-check-input" type="radio" name="density" id="density510" value="510">
                                <label class="form-check-label" for="density510">
                                    510
                                </label>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="form-group col-2">
                <fieldset class="form-group col-12">
                    <div class="form-group row">
                        <legend class="col-12">Размеры</legend>
                        <label class="col-12 form-check-label" for="dimensions-width">Ширина, м</label>
                        <div class="col-12">
                            <input v-model="widthSize" type="text" class="form-control" id="dimensions-width">
                        </div>
                        <label class="col-12 form-check-label" for="dimensions-height">Длина, м</label>
                        <div class="col-12">
                            <input v-model="heightSize" type="text" class="form-control" id="dimensions-height">
                        </div>
                    </div>
                </fieldset>                
            </div>
            <div class="form-group col-2">
                <legend>Проклейка</legend>
                <div class="row">
                    <div class="col-12">
                        <div class="form-check">
                            <input v-model="sizingAll" id="sizing" class="form-check-input" type="checkbox" value="true">
                            <label class="form-check-label" for="sizing">
                                Проклейка
                            </label>
                        </div>
                    </div>                    
                </div>                
                <div class="row">
                    <div class="col-12">
                        <div class="form-check form-group">
                            <input v-bind:disabled="disabledSizing" class="form-check-input" type="checkbox" v-model="sizingTop" value="true" id="sizingTop">
                            <label class="form-check-label" for="sizingTop">
                                Проклейка верх
                            </label>
                        </div>
                    </div>                    
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="form-check">
                            <input v-bind:disabled="disabledSizing" class="form-check-input" type="checkbox" v-model="sizingBottom" id="sizingBottom" value="true">
                            <label class="form-check-label" for="sizingBottom">
                                Проклейка низ
                            </label>
                        </div>
                    </div>                    
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="form-check">
                            <input v-bind:disabled="disabledSizing" class="form-check-input" type="checkbox" v-model="sizingLeft" value="true" id="sizingLeft">
                            <label class="form-check-label" for="sizingLeft">
                                Проклейка слева
                            </label>
                        </div>
                    </div>                    
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="form-check">
                            <input v-bind:disabled="disabledSizing" class="form-check-input" type="checkbox" v-model="sizingRight" value="true" id="sizingRight">
                            <label class="form-check-label" for="sizingRight">
                                Проклейка справа
                            </label>
                        </div>
                    </div>                    
                </div>
            </div>
            <div class="form-group col-4">
                <legend>Люверсы</legend>
                <div class="row">
                    <div class="col-6">                        
						
                    </div>
                    <div class="col-6">
					<div class="row">
						<div class="col-6">
							<div class="row">
								<input class="col-12" type="radio" name="variantLuvers" id="step" value="step" v-model="variantLuvers">
								<label class="col-12 text-center" for="step">Шаг, м</label>						
							</div>
						</div>
						<div class="col-6">
							<div class="row">
								<input class="col-12" type="radio" name="variantLuvers" id="count" value="count" v-model="variantLuvers">
								<label class="col-12 text-center" for="count">Кол-во</label>
							</div>
						</div>
					</div>
                    </div>                    
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-check form-check-inline">
                            <input id="luversAll" class="form-check-input" type="checkbox" v-model="luversAll" value="true">
                            <label class="form-check-label" for="luversAll">
                                Люверсы
                            </label>
                        </div>
                    </div>
                    <div class="col-6">
                        <input v-model="cntLuverAll" class="form-control" type="number" step="1">
                    </div>                    
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-check form-group">
                            <input v-bind:disabled="disabledLuvers" class="form-check-input" type="checkbox" v-model="luversTop" value="true" id="luversTop">
                            <label class="form-check-label" for="luversTop">
                                Люверсы верх
                            </label>
                        </div>
                    </div>                    
                    <div class="col-6">
                        <input v-bind:disabled="disabledLuvers" v-model="cntLuverTop" class="form-control" type="number" step="1">
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-check">
                            <input v-bind:disabled="disabledLuvers" class="form-check-input" type="checkbox" v-model="luversBottom" id="luversBottom" value="true">
                            <label class="form-check-label" for="luversBottom">
                                Люверсы низ
                            </label>
                        </div>
                    </div>                    
                    <div class="col-6">
                        <input v-bind:disabled="disabledLuvers" v-model="cntLuverBottom" class="form-control" type="number" step="1">
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-check">
                            <input v-bind:disabled="disabledLuvers" class="form-check-input" type="checkbox" v-model="luversLeft" value="true" id="luversLeft">
                            <label class="form-check-label" for="luversLeft">
                                Люверсы слева
                            </label>
                        </div>
                    </div>
                    <div class="col-6">
                        <input v-bind:disabled="disabledLuvers" v-model="cntLuverLeft" class="form-control" type="number" step="1">
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-check">
                            <input v-bind:disabled="disabledLuvers" class="form-check-input" type="checkbox" v-model="luversRight" value="true" id="luversRight">
                            <label class="form-check-label" for="luversRight">
                                Люверсы справа
                            </label>
                        </div>
                    </div>
                    <div class="col-6">
                        <input v-bind:disabled="disabledLuvers" v-model="cntLuverRight" class="form-control" type="number" step="1">
                    </div>
                </div>
            </div>

            <div class="form-group col-md-2">                
                <div class="col-12 total-price">
					
                    <span class="total" v-bind:text-content.prop="totalCost"></span><span>р.</span>
                </div>
            </div>			
			<div class="error">{{ error_size }}</div>
				{{ test }}--{{ discount }} - {{ perimeter }}
        </div>
        <hr>
        
    </form>
</div>
<script>
var app = new Vue({ 
    el: "#app",
    data: {         
        typeClient: '1',        
		variantLuvers: 'step',
        cost330: '0',
        cost440: '0',
        cost510: '0',
        self330: '50',
        self440: '60',
        self510: '100',
        density: '330',				
        rollwidth: '1.1',
        widthSize: '',
        heightSize: '',
        sizingAll: false,        
        luvers: [],
        luversAll: false,
        luversTop: 0,
        luversBottom: 0,
        luversLeft: 0,
        luversRight: 0,
        sizingTop: 0,
        sizingBottom: 0,
        sizingLeft: 0,
        sizingRight: 0,
        sizingCostRetail:50,
        sizingCostOpt:30,
        disabledLuvers: false,
        disabledSizing: false,
        stepLuverAll: 0,
        stepLuverTop: 0,
        stepLuverBottom: 0,
        stepLuverRight: 0,
        stepLuverLeft: 0,
        cntLuverAll: 0,
        cntLuverTop: 0,
        cntLuverBottom: 0,
        cntLuverRight: 0,
        cntLuverLeft: 0, 
        oneLuversCost: 0,       
        oneLuversCostRetail: 20,
        oneLuversCostOpt: 15,
		error_size:'0',
		test: '',
		rollWidthList:[		
			{ width:1.1 }, 
			{ width:1.37 }, 
			{ width:1.6 }, 
			{ width:2.2 }, 
			{ width:2.5 }, 
			{ width:3.2 }
			
		],
		discount:'0',
		discountList:[
			{10:5},
			{20:7},
			{50:10},
			
		],
        prices: {
            1: { name: 'Розница', 330: 240, 440: 250, 510: 350 },            
        },
        selfPrice: {
            330: 50,
            440: 60,
            510: 100
        }
    },
	watch:{ 
		selectRoll: function(){},
		costMetr: function(){},
		costBanner: function(){},
		cutSize: function(){},
		cutPrice: function(){},
		perimeter: function(){},
		sizingCost: function(){},
		oneLuversCost: function(){},
		luversCost: function(){},
		totalCost: function(){}
	},
    computed: {
		dimensionsWidth: function(){
			return this.widthSize.replace(/,/, '.')
		},
		dimensionsHeight: function(){
			return this.heightSize.replace(/,/, '.')
		},
        totalCost: function() {
        		var result = 0;
        		var disc = 0;
        		result = this.costBanner * 1 + this.sizingCost * 1 + this.luversCost * 1;
            return (result - disc + this.cutPrice * 1).toFixed(0)
        },
        perimeter: function() {			
			if(this.dimensionsWidth > 3.2 && this.dimensionsHeight > 3.2){
				this.error_size = 'Хотя бы одна из сторон не должна превышать 3,2 метра'
				return 0
			}else{
				this.error_size = ''
				var resultPer = this.dimensionsWidth * 2 + this.dimensionsHeight * 2
				if(resultPer>=10 && resultPer <= 20){
					this.discount = '5'
				}else if(resultPer>=20 && resultPer <= 50){
					this.discount = '7'
				}else if(resultPer>=20 && resultPer <= 50){
					this.discount = '10'
				}
				return resultPer
			}
            
        },
		selectRoll: function() {		
		if(this.dimensionsHeight == 0 && this.dimensionsWidth == 0){
				//return this.rollwidth = 1.1				
			}else{				
				var rw;
				var check = 0;
				this.rollWidthList.forEach(function(item, i, rollWidthList){					
					if(app.dimensionsHeight>item.width && app.dimensionsWidth>item.width){
						
					}else{		
						if(check == 0){
							rw = item.width;						
							check = 1;							
						}						
					}
					//console.log(this.dimensionsHeight+'>'+item.width+':'+this.dimensionsWidth+'>'+item.width);
				})
				//console.log(rw)
				return this.rollwidth = rw
			}
        },
        cutPrice: function() {
            return (this.cutSize * this.selfPrice[this.density] * 1.5).toFixed(0)
        },        
        cutSize: function() {
        		if(this.dimensionsWidth > 0 && this.dimensionsHeight > 0){
        			var max;
	            var min;
	            if (this.dimensionsWidth > this.dimensionsHeight) {
	                max = this.dimensionsWidth;
	                min = this.dimensionsHeight;
	            } else {
	                max = this.dimensionsHeight;
	                min = this.dimensionsWidth;
	            }
	            if (max <= this.rollwidth) {
	                return ((this.rollwidth - max) * min).toFixed(2);
	            } else if (min <= this.rollwidth) {
	                return ((this.rollwidth - min) * max).toFixed(2);
	            } else {
	                return "Какая то херня с размерами";
	            }	
        		}else{
        			return 0
        		}
            
        },
        costMetr: function() {            
			this.cost330 = this.prices[1]['330'];
			this.cost440 = this.prices[1]['440'];
			this.cost510 = this.prices[1]['510'];
			return this.prices[1][this.density];            
        },
        costBanner: function() {
			if(this.discount > 0){
				return ((this.costMetr * this.dimensionsWidth * this.dimensionsHeight)-(this.costMetr * this.dimensionsWidth * this.dimensionsHeight)/100*this.discount).toFixed(0);
			}else{
				return (this.costMetr * this.dimensionsWidth * this.dimensionsHeight).toFixed(0);
			}
            
        },
        sizingCost: function() {
        		var cost = 0;
        		if (this.typeClient == 2){
        			cost = this.sizingCostOpt
        		}else{ 
        			cost = this.sizingCostRetail
        		}
            if (this.sizingAll) {
              this.disabledSizing = true;
              return this.perimeter * cost;
            } else {
              this.disabledSizing = false;
              var top = 0;
              var left = 0;
              var right = 0;
              var bottom = 0;
              if(this.sizingTop){
                top = this.dimensionsWidth*cost
              }
              if(this.sizingBottom){
                bottom = this.dimensionsWidth*cost
              }
              if(this.sizingLeft){
                left = this.dimensionsHeight*cost
              }
              if(this.sizingRight){
                right = this.dimensionsHeight*cost
              }
                return top+bottom+left+right;              
            }
        },
        luversCost: function() {        		        		
        	this.oneLuversCost = this.oneLuversCostRetail        		
            if (this.luversAll) {
                this.disabledLuvers = true;
                if(this.variantLuvers == 'count'){										
                	return (this.cntLuverAll*this.oneLuversCost).toFixed(0)					
                }else if ((this.variantLuvers == 'step') && (this.perimeter > 0)) {					
                    var result  = (this.perimeter / this.cntLuverAll * this.oneLuversCost).toFixed(0)
					if(isFinite(result)){						
						return result
					}else{						
						return '0'
					}					
                } else {										
                    return '0'
                }
            } else {
                this.disabledLuvers = false;
                var top = 0;
                var left = 0;
                var right = 0;
                var bottom = 0;

                top = calcLuvers(this.luversTop, this.stepLuverTop, this.cntLuverTop, this.dimensionsWidth, this.oneLuversCost)

                bottom = calcLuvers(this.luversBottom, this.stepLuverBottom, this.cntLuverBottom, this.dimensionsWidth, this.oneLuversCost)                

                left = calcLuvers(this.luversLeft, this.stepLuverLeft, this.cntLuverLeft, this.dimensionsHeight, this.oneLuversCost)                

                right = calcLuvers(this.luversRight, this.stepLuverRight, this.cntLuverRight, this.dimensionsHeight, this.oneLuversCost)                                

                return (top + bottom + left + right) * 1
            }
        }
    }
})
function calcLuvers(nameCheck, nameStep, nameCnt, sideBanner, cost){
	if(nameCheck && nameCnt>0){
		return nameCnt*cost
	}else	if (nameCheck && (nameStep > 0)) {
      return sideBanner / nameStep * cost
  } else {
      return 0
  }
}
function numPlus(num) {
    if (num > 0) {
        return num
    } else {
        return 0
    }
}
</script>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>