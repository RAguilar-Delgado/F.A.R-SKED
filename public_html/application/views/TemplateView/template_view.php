<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
<script>
	$(window).on('load', function(){
		new template_view({pageData:<?=$pageData?>});
	})

	function template_view(opts){
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

	template_view.prototype = {
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
				$('<div>', {class: 'w-100 rounded border-bottom font-weight-bold', text:'(F.A.R SKED) - Home', css: {color:'#5784A9', fontSize:'1.25rem'}})
			)
			
			return $header;
		},
		build_body: function(){
			const $cont = $('<div>', {class: 'col-12'});
			$cont
			.append(
				$('<div>', {class:'container-fluid w-100'})
				.append(
					$('<div>', {class:'row w-100'})
					.append(
						//this is where you would append more cols
					)
				)
			)
		}
	}
</script>

<div id="login_page" class="container-fluid">
	<div id="login_cont" class="row">
	</div>
</div>