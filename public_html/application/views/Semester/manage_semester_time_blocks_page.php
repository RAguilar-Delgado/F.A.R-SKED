
<script>
	$(window).on('load', function(){
		new manage_semester_time_blocks_page({pageData:<?=$pageData?>});
	})

	function manage_semester_time_blocks_page(opts){
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

	manage_semester_time_blocks_page.prototype = {
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
				$('<div>', {class: 'w-100 rounded border-bottom font-weight-bold', text:'(F.A.R SKED) - Manage Semester Time Blocks', css: {color:'#5784A9', fontSize:'1.25rem'}})
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
						
					)
				)
			)
			return $body;
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

<body style="background-image: url('/~depsked/assets/images/banner.jpg');">
	<div id="page" class="container-fluid" >
		<div id="
		" class="row">
		</div>
	</div>
</body>