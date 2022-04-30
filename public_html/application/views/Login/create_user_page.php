
<script>
	$(window).on('load', function(){
		new create_user({pageData:<?=$pageData?>});
	})

	function create_user(opts){
		const self = this;
		self.opts = $.extend(true, {
			$cont: $('#page_cont'),
			privs: {}
		}, opts);

		for(let x in self.opts){
			self[x] = self.opts[x];
		}
		console.log(self.pageData);
		delete self.opts;
		self.init();
	}

	create_user.prototype = {
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
				$('<div>', {class: 'w-100 rounded border-bottom font-weight-bold', text:'(F.A.R SKED) - Create User', css: {color:'#5784A9', fontSize:'1.25rem'}})
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
			self.$password1 = $('<input>', {type:'password', class:'form-control', css:{width:'90%'}});
			self.$password2 = $('<input>', {type:'password', class:'form-control', css:{width:'90%'}});
			const $createUserBtn = $('<button>',{type:'button', class:'btn btn-primary mt-2 mr-1', text:'Create User '});

			$cont
			.append(
				$('<div>', {class:'container-fluid w-100 py-2', css: {fontSize: '1rem', minHeight:'82px'}})
				.append(
					$('<div>', {class:'row pr-2'})
					.append(
						$('<label>', {text:'User Name', class:'col-12'})
					),
					$('<div>',{class:'row pr-2 d-flex flex-row'})
					.append(
						$('<div>',{class:'fas fa-user fa-fw text-center', css:{fontSize:'2rem', width:'10%'}}),
						self.$username
					),
					$('<div>', {class:'row pr-2'})
					.append(
						$('<label>', {text:'Password', class:'col-12'})
					),
					$('<div>',{class:'row pr-2 d-flex flex-row'})
					.append(
						$('<div>',{class:'fas fa-key fa-fw text-center', css:{fontSize:'2rem', width:'10%'}}),
						self.$password1	
					),
					$('<div>', {class:'row pr-2'})
					.append(
						$('<label>', {text:'Confirm Password', class:'col-12'})
					),
					$('<div>',{class:'row pr-2 d-flex flex-row'})
					.append(
						$('<div>',{class:'fas fa-check fa-fw text-center', css:{fontSize:'2rem', width:'10%'}}),
						self.$password2
					),
					$('<div>',{class:'row d-flex justify-content-center'})
					.append(
						$createUserBtn
						.append(
							$('<i>',{class:'fas fa-user-plus'})
						)
					)
				)
			)

			$createUserBtn.on('click', function(){
				self.create_user_save();
			})
			return $cont;
		},
		create_user_save: function(){
			const self = this;
			const password1 = self.$password1.val();
			const password2 = self.$password2.val();

			if(password1 == '' || password2 == ''){
				self.set_form_status_msg("Password input left empty please fill out both fields!","alert-danger alert-dismissible",false,3000);
				return;
			}
			if(password1 != password2){
				self.set_form_status_msg("Passwords do not match!","alert-danger alert-dismissible",false,3000);
				return;
			}

			const data = {
				Username : self.$username.val(),
				Password : password1
			}

			$.ajax({
				type:'POST',
				url:'/~depsked/Login/create_user_save',
				dataType: "json",
				data: data,
				success: function(d){
					console.log(d);
					if(d.error > 0){
						self.set_form_status_msg("Create user failed! " + d.errorMsg,"alert-danger alert-dismissible",false,3000);
					} else {
						self.set_form_status_msg("Create user successfull!  Redirecting you to login.","alert-success alert-dismissible",false,3000, '/~depsked/');
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
		const $page = $('#page_cont');
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
					window.location = redirect;
				}
			},
			fadeTime
			)
		}
	},
	}
</script>

<div id="page" class="container-fluid">
	<div id="page_cont" class="row">
	</div>
</div>