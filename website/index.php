<html>
<title> VUE APP</title>
<head>
	
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</head>
<body>
	<div class="container" id='app'>
		<h3>Subscribe to our newslettter Below</h3>
	
		<div class="row">
			<div class="col-md-6">
		 		<button class="btn btn-info" @click="subscribeUser"> Click here to Subscribe</button>
				
			</div>
			<div class="col-md-6">
				<button class="btn btn-secondary" @click="refresh">Refresh Table</button>
				
			</div>
		</div>

		 <div class="row">
		 	<div class="col-md-12" v-if="items.length == 0">No Logs Yet</div>
			 <div class="table-responsive"> 
			 	<table class="table table-striped" v-if="items.length > 0">
			 		<tr>
			 			<td>S/N</td>
			 			<td>Email</td>
			 			<td>Status</td>
			 			<td>Mailable</td>
			 			<td>Date Sent</td>
			 		</tr>
			 		<tr v-for="(item, index) in items" >
			 			<td class="text-center">{{index + 1}} </td>
			 			<td>{{item.email}} </td>
			 			<td>{{item.status}} </td>
			 			<td>{{item.mailable}} </td>
			 			<td>{{item.updated_at}} </td>
			 		</tr>
			 	</table>
				
			 </div>
		</div>
	</div>

<script type="text/javascript">
	 var vmSidebar =  new Vue({
              el: "#app",
              data: {
           		items: []
              },
              created(){
              	// fetch data from API backend
              	this.getData()
              },
              mounted(){
                console.log("mounted")
              },
              methods:{
              	refresh(){
              		this.getData()
              	},
              	getData(){
              		var self  = this;
					// Make a request for a user with a given ID
					axios.get('http://192.168.99.100:80/api/show')
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
					    // always executed
					  });
              	},
              	subscribeUser(){
              /*	axios.get('http://192.168.99.100:80/api/show') 
              		.then(function (response) {
					    // handle success
					     console.log(response);
					    
					  })*/
					axios.post('http://192.168.99.100:80/api/sendEmail', {
						
					    'to': 'John Doe',
					    'email': 'johndoe@email.com',		  
					    'subject': 'You have been subscribed',		  
					    'message_text': 'required',		  
					    'token': 'token123',
					     'mailable':"UserSubscribed"
					 	
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
</body>

</html>
