var app = new Vue({
    el: "#app",
    data: {
        laminationPrice:500,
        moldingPrice:100,
        moldingPrice:50,
        cornerPrice:30,
        springPrice:15,
        moldingWidth:3, 
        poketPrice:2,                
        a4:{
            width: 20,
            height: 10,
            cost:200
        },
        thickness:{ 
            1:{
                name: '1-3мм',
                val:1,
                price: {
                    0.02 : 5000,
                    0.05 : 4000,
                    0.2 : 3000,
                    0.5 : 2500,
                    1 : 2000,
                },
                priceNow : 5000
            },
            2:{
                name: '5мм',
                val:2,
                price: {
                    0.02 : 7000,
                    0.05 : 6000,
                    0.2 : 5000,
                    0.5 : 3700,
                    1 : 2500,
                },
                priceNow : 7000
            },            
            3:{
                name: 'ќцинковка',
                val:3,
                price: {
                    0.02 : 6000,
                    0.05 : 5000,
                    0.2 : 4000,
                    0.5 : 3000,
                    1 : 2000,
                },
                priceNow : 6000
            },
        },
        nameplates: [{
            width: '',
            height: '',
            thickness: 1,
            lamination: false,
            laminationCost:0,
            molding: false,
            count:1,
            area:0,
            pokets:[],
            poketsCost:0,
            err: '',
            costArea: 0, 
            totalCost: 0
        }],   
        test: 'test1',
        err: ''
    },
    methods: {
        addNewNameplate() {
            this.nameplates.push({
                width: '',
                height: '',
                thickness: 1,
                lamination: false,
                laminationCost:0,
                molding: false,
                count:1,
                area:0,
                pokets:[],
                poketsCost:0,
                err: '', 
                costArea: 0,
                totalCost: 0
            })
        },
        deleteNameplate(index){
            this.nameplates.splice(index, 1)
        },
        addNewPoket(indexPlate){
            this.nameplates[indexPlate].pokets.push({
                size: 1,
                count: 1,
                width: 0,
                height: 0,
            })            
        },
        deletePoket(indexPlate, indexPoket){
            this.nameplates[indexPlate].pokets.splice(indexPoket, 1)
        },
        showPoketSize(indexPlate, indexPoket){
            if(this.nameplates[indexPlate].pokets[indexPoket].size == 2){
                return true
            }else{
                return false;
            }

        }        
    },
    watch: {
        
    },
    computed: {
        totalArea: function(){
            var area = 0;
            for(var i=0; i<this.nameplates.length; i++){
                var height = this.nameplates[i].height.toString().replace(/,/, '.')
                var width = this.nameplates[i].width.toString().replace(/,/, '.')
                area = area+(height.replace(/,/, '.')*width)                
            }
            return Math.ceil(area*1000)/1000
        }, 
        calculating: function(){            
            var arr = {};            
            var multiplier = 0;            
            for(var i=0; i<this.nameplates.length; i++){
                if(arr[this.nameplates[i].thickness] == undefined){
                    arr[this.nameplates[i].thickness] = {}
                }                
                if(isNaN(arr[this.nameplates[i].thickness].area)){
                    arr[this.nameplates[i].thickness].area = 0
                }
                var width = this.nameplates[i].width.toString().replace(/,/, '.')
                var height = this.nameplates[i].height.toString().replace(/,/, '.')
                this.nameplates[i].area = width * height
                this.nameplates[i].area = Math.ceil(this.nameplates[i].area*1000)/1000
                arr[this.nameplates[i].thickness].area += width * height

                if(arr[this.nameplates[i].thickness].area<'0.02'){                    
                    this.nameplates[i].priceArea = this.thickness[this.nameplates[i].thickness].price['0.02']                    
                }else if(arr[this.nameplates[i].thickness].area >= '0.02' && arr[this.nameplates[i].thickness].area < '0.05'){                    
                    this.nameplates[i].priceArea = this.thickness[this.nameplates[i].thickness].price['0.05']
                }else if(arr[this.nameplates[i].thickness].area>='0.05' && arr[this.nameplates[i].thickness].area<'0.2'){                    
                    this.nameplates[i].priceArea = this.thickness[this.nameplates[i].thickness].price['0.2']
                }else if(arr[this.nameplates[i].thickness].area>='0.2' && arr[this.nameplates[i].thickness].area<'0.5'){                    
                    this.nameplates[i].priceArea = this.thickness[this.nameplates[i].thickness].price['0.5']
                }else if(arr[this.nameplates[i].thickness].area>='0.5'){
                    this.nameplates[i].priceArea = this.thickness[this.nameplates[i].thickness].price['1']
                }
                if(isNaN(arr[this.nameplates[i].thickness].cost)){
                    arr[this.nameplates[i].thickness].cost = 0
                }
                this.nameplates[i].costArea = this.nameplates[i].area*this.nameplates[i].priceArea
                this.nameplates[i].costArea = this.nameplates[i].costArea.toFixed(2)
                if(this.nameplates[i].lamination){
                    this.nameplates[i].laminationCost = this.nameplates[i].area*this.laminationPrice
                }else{
                    this.nameplates[i].laminationCost = 0
                }                
                if(this.nameplates[i].pokets.length>0){                    
                    this.nameplates[i].poketsCost = 0*1
                    for(var t=0; t<this.nameplates[i].pokets.length; t++){
                        width = 0
                        height = 0
                        if(this.nameplates[i].pokets[t].size == 1){
                            this.nameplates[i].poketsCost += this.a4.cost*this.nameplates[i].pokets[t].count
                        }else{
                            height = this.nameplates[i].pokets[t].height.toString().replace(/,/, '.')
                            width = this.nameplates[i].pokets[t].width.toString().replace(/,/, '.')
                            this.nameplates[i].poketsCost += width*height*(this.a4.cost*16)*this.nameplates[i].pokets[t].count
                        }                        
                    }
                    this.nameplates[i].poketsCost =  Math.ceil(this.nameplates[i].poketsCost*1000)/1000
                }
            }       
            arr['total'] = 0
            for(key in arr){
                if(!isNaN(arr[key].cost)){
                    arr['total'] += arr[key].cost
                }                
            }
            arr['total'] = Math.ceil(arr['total'])
            return arr
        },        
        /*costLamination: function(){
            var res = 0;
            for(var i=0; i<this.nameplates.length; i++){
                if(this.nameplates[i].lamination){
                    this.test = 'lam'
                    res += this.nameplates[i].area*this.laminationPrice
                    this.nameplates[i].laminationCost = this.nameplates[i].area*this.laminationPrice
                }
            }
            return Math.ceil(res)
        },*/
        costMolding: function(){
          var res = 0;          
            for(var i=0; i<this.nameplates.length; i++){                
                if(this.nameplates[i].molding){
                    var width
                    var height
                    if(this.nameplates[i].width > this.nameplates[i].height){
                        width = this.nameplates[i].width.toString().replace(/,/, '.')*1
                        height = this.nameplates[i].height.toString().replace(/,/, '.')*1
                    }else{
                        height = this.nameplates[i].width.toString().replace(/,/, '.')*1
                        width= this.nameplates[i].height.toString().replace(/,/, '.')*1        
                    }                    
                    if(height>0 && width>0){
                        if(width*2+height*2 <= this.moldingWidth){
                            res += this.moldingPrice*1                            
                        }else if(width + height <= this.moldingWidth){   
                            res += this.moldingPrice*2                            
                        }else{                                                
                            if(height*2 <= this.moldingWidth && width<=this.moldingWidth){
                                res += this.moldingPrice*3 
                                this.nameplates[i].err = ''
                            }else if(height <= this.moldingWidth && width<=this.moldingWidth){
                                res += this.moldingPrice*4
                                this.nameplates[i].err = ''
                            }else{
                                this.nameplates[i].err = 'стороны длинее багета'
                                res += 0
                            }
                        }                    
                    }                    
                }
            }
            return Math.ceil(res*1000)/1000
        },        
        costPoket: function(){

        }, 
        totalCost: function(){
            /*return this.costArea.total*1 + this.costLamination*1 + this.costMolding*1*/
            var result = 0
            for(var c=0; c<this.nameplates.length; c++){
                this.nameplates[c].totalCost = this.nameplates[c].costArea*1 + this.nameplates[c].laminationCost*1+this.nameplates[c].poketsCost
                result += this.nameplates[c].costArea*1 + this.nameplates[c].laminationCost*1+this.nameplates[c].poketsCost*1
            }
            return result+this.costMolding
        }
    },
    filters:{
        toPoint: function(value){
            if (!value) return ''            
            return value.replace(/,/, '.')
        }
    }
})