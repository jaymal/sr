@extends('layouts.app')

@section('content')

<div class="container" id='app'>
        <h3>Convert your currencies Below</h3>
    
        <div class="row">
            
            <div class="form-group col-4 col-md-4">
               <!--  <label>From Currency</label> -->
                <input type="number" placeholder="Amount"  name="amount"   v-model='amount'>
                
            </div>

            <div class="form-group col-4 col-md-4" >
                <label>From Currency</label>
                <select id="from_currency" v-model='from_currency' name="from_currency" value="{{ old('from_currency') }}">
                    <option selected>Choose</option>
                    @foreach($currencies as $currency)
                    <option value="{{$currency}}" @if (old('from_currency') == $currency){{"selected" }} @endif>{{$currency}}</option>
                    @endforeach
                 </select>
                
            </div>
            <div class="form-group col-4 col-md-4" >
                <label>To Currency</label>
                 <select id="to_currency" v-model="to_currency" name="to_currency" value="{{ old('to_currency') }}">
                    <option selected>Choose</option>
                    @foreach($currencies as $currency)
                    <option value="{{$currency}}" @if (old('to_currency') == $currency){{"selected" }} @endif>{{$currency}}</option>
                    @endforeach
                 </select>
                
            </div>
        </div>
      
        <div class="row">
            <div class="form-group col-md-6">
                 <button class="btn btn-info" @click="convert"> Convert</button>
                
            </div>
            <div class="form-group col-md-6">
                 <div>
                     @{{convertedAmount}}
                 </div>
                
            </div>
        
        </div>
        
        <div class="row">
            <div class="form-group col-md-12">
                <button class="btn btn-secondary" @click="refresh">Refresh Logs</button>
                
            </div>
        </div>

         <div class="row">
            <div class="col-md-12" v-if="items.length == 0">@{{nologs}}</div>
             <div class="table-responsive"> 
                <table class="table table-striped" v-if="items.length > 0">
                    <tr>
                        <td>S/N</td>
                        <td>Amount</td>
                        <td>From</td>
                        <td>To</td>
                        <td>Value</td>
                    </tr>
                    <tr v-for="(item, index) in items" >
                        <td class="text-center">@{{index + 1}} </td>
                        <td>@{{item.amount}} </td>
                        <td>@{{item.from_currency}} </td>
                        <td>@{{item.to_currency}} </td>
                        <td>@{{item.converted}} </td>
                    </tr>
                </table>
                
             </div>
        </div>
    </div>

@endsection
@section('js')
<script type="text/javascript">
     var vm =  new Vue({
              el: "#app",
              data: {
                items: [],
                amount:'',
                from_currency:'',
                to_currency:'',
                convertedAmount:'',
                nologs: 'No Logs Yet'
              },
              created(){
                // fetch data from API backend
                this.getHistory()
              },
              mounted(){
                console.log("mounted")
              },
              methods:{
                refresh(){
                    this.nologs = "wait..";
                    this.getHistory()                   
                },
                getHistory(){
                    var self  = this;
                    let url = "{{url('/history')}}";
                    axios.get(url)
                      .then(function (response) {
                        // handle success
                        if(response.data){
                            self.items = response.data;

                        }else{
                            self.items =[]
                        }
                      })
                      .catch(function (error) {
                        // handle error
                        console.log(error);
                      })
                      .finally(function () {
                            if(self.items.length == 0){
                                self.nologs = 'No Logs Yet'; 
                            }
                      });
                },
                convert(){
                    console.log(this.amount);
                    this.convertedAmount = '...loading';

                    var self = this
                    let apiBaseUrl = "{{ $apiBaseUrl }}";
                    let url =  apiBaseUrl+':80/api/convert/'+this.amount+ '/'+ this.from_currency+'/'+this.to_currency

                    axios.get(url)
                      .then(function (response) {
                        console.log(response.data.data);
                        // handle success
                        if(response.data){
                            self.convertedAmount = response.data.data;
                            self.logHistory()

                        }else{
                            self.convertedAmount =''
                        }
                      })
                      .catch(function (error) {
                        // handle error
                        console.log(error);
                      })
                      .finally(function () {
                        // always executed
                      });
                    /*
                    */
                },
                logHistory(){
                     let url = "{{url('/history')}}";
                     axios.post(url, {
                        'amount': this.amount,
                        'to_currency': this.to_currency,          
                        'from_currency': this.from_currency,        
                        'converted': this.convertedAmount,      
                        
                      })
                      .then(function (response) {
                        console.log(response);
                      })
                      .catch(function (error) {
                        console.log(error);
                      });
                }
              }
          });
</script>
@endsection
