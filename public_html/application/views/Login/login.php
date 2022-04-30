
<script>
	$(window).on('load', function(){
		new login({pageData:<?=$pageData?>});
	})

	function login(opts){
		const self = this;
		self.opts = $.extend(true, {
			$cont: $('#login_cont'),
			privs: {}
		}, opts);

		for(let x in self.opts){
			self[x] = self.opts[x];
		}
		console.log(self.pageData);
		delete self.opts;
		self.init();
	}

	login.prototype = {
		init: function(){
			const self = this;
			self.build_html();
		},
		build_html: function(){
			const self = this;
			self.$cont
			.append(
				self.build_header(),
				self.build_body()
			)
			
		},
		build_header: function(){
			const self = this;
			const $header = $('<div>', {class: 'col-12'});

			$header
			.append(
				$('<div>', {class: 'w-100 rounded border-bottom font-weight-bold', text:'(F.A.R SKED) - Login', css: {color:'#5784A9', fontSize:'1.25rem'}})
			)
			
			return $header;
		},
		build_body: function(){
			const self = this;
			const $body = $('<div>', {class: 'col-12'});

			$body
			.append(
				$('<div>',{class:'container-fluid'})
				.append(
					$('<div>', {class:'row d-flex justify-content-center', css:{height:'600px'}})
					.append(
						self.build_login()
					)
				)
			)
			return $body;
		},
		build_login: function(){
			const self = this;
			const $cont = $('<div>',{class:'rounded border border-primary col-6 align-self-center', css:{}});

			self.$username = $('<input>', {type:'text', class:'form-control', css:{width:'90%'}});
			self.$password = $('<input>', {type:'password', class:'form-control', css:{width:'90%'}});
			self.$loginBtn = $('<button>',{type:'button', class:'btn btn-primary mt-2 mr-1', text:'Login '});
			const $homeBtn = $('<button>',{type:'button', class:'btn btn-primary mt-2 mr-1', text:'Home '});
			const $createUserBtn = $('<button>',{type:'button', class:'btn btn-primary mt-2 mr-1', text:'Create User '});

			$cont
			.append(
				$('<div>', {class:'container-fluid w-100 py-2', css: {fontSize: '1rem', minHeight:'82px'}})
				.append(
					$('<div>', {class:'row w-100'})
					.append(
						$('<label>', {text:'User Name', class:'col-12'})
					),
					$('<div>',{class:'row w-100 d-flex flex-row'})
					.append(
						$('<div>',{class:'fas fa-user fa-fw text-center', css:{fontSize:'2rem', width:'10%'}}),
						self.$username
					),
					$('<div>', {class:'row w-100'})
					.append(
						$('<label>', {text:'Password', class:'col-12'})
					),
					$('<div>',{class:'row w-100 d-flex flex-row'})
					.append(
						$('<div>',{class:'fas fa-key fa-fw text-center', css:{fontSize:'2rem', width:'10%'}}),
						self.$password	
					),
					$('<div>',{class:'row w-100 d-flex justify-content-center'})
					.append(
						self.$loginBtn
						.append(
							$('<i>',{class:'fas fa-arrow-right'})
						),
						$createUserBtn
						.append(
							$('<i>',{class:'fas fa-user-plus'})
						),
						$homeBtn
					)
				)
			)

			self.$loginBtn.on('click', function(){
				self.login_save();
			})

			$homeBtn.on('click', function(){
				window.location = '/~depsked/Home/home_page';
			})

			$createUserBtn.on('click', function(){
				window.location = '/~depsked/Login/create_user_page';
			})
			return $cont;
		},
		login_save: function(){
			const self = this;
			const data = {
				Username : self.$username.val(),
				Password : self.$password.val()
			}

			$.ajax({
				type:'POST',
				url:'/~depsked/Login/login_save',
				dataType: "json",
				data: data,
				success: function(d){

					if(d.error > 0){
						self.set_form_status_msg("Login failed. Incorrect username or password!","alert-danger alert-dismissible",false,3000);
					} else {
						self.set_form_status_msg("Login successfull!","alert-success alert-dismissible",false,3000,'/~depsked/Home/home_page')
					}
				},
				error: function( jqxhr, textStatus, error ){
					const err = textStatus + ", " + error;
					console.log( "Request Failed: " + err );
				}
			});
		},
		create_user_save: function(){
			const self = this;

			const data = {
				Username : self.$username.val(),
				Password : self.$password.val()
			}

			$.ajax({
				type:'POST',
				url:'/~depsked/Login/create_user_save',
				dataType: "json",
				data: data,
				success: function(d){
					console.log(d);
					if(d.error > 0){
						self.set_form_status_msg("Create user failed!","alert-danger alert-dismissible",false,3000);
					} else {
						self.set_form_status_msg("Create user successfull!  Please login.","alert-success alert-dismissible",false,3000,'/~depsked/home_page');
						self.$username.val('');
						self.$password.val('');
					}

				},
				error: function( jqxhr, textStatus, error ){
					const err = textStatus + ", " + error;
					console.log( "Request Failed: " + err );
				}
			});
		},
		set_form_status_msg: function(msg = '', classes = '', type = false, fadeTime = false, redirect = false){
		const self = this;
		const $page = $('#login_cont');
		$page.find('.alert').remove();
		if(!msg){
			return;
		}	

		const $alert = $('<div>', {text:msg, class:"alert fade show text-center", role:"alert", type:type, css:{position:'absolute', top:'5px', left:"1.25rem", right:"1.25rem", fontSize:'1rem'}});
		$alert.addClass(classes);

		if($alert.hasClass('alert-dismissible')){
			$alert
			.append(
				$('<button>', {type:'button', class:"close", 'data-dismiss':"alert"})
				.append(
					$('<span>', {html:'&times;'})
				)
			);
		}


		$page.append($alert);

		if(fadeTime){
			setTimeout(function(){
				$page.find('.alert').fadeOut("slow");
				if(redirect){
					window.location = redirect
				}
			},
			fadeTime
			)
		}
	},
	}
</script>

<div id="login_page" class="container-fluid">
	<div id="login_cont" class="row">
	</div>
</div>