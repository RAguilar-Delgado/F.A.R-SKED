<head>
    <meta name="viewport" content="with=device-width, initial-scale=1.0">
    <title> Homepage</title>
    <link rel="stylesheet" href="/~depsked/assets/stylesheets/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@700&display=swap" rel="stylesheet">
</head>
<script>
	$(window).on('load', function(){
		new home_page({pageData:<?=$pageData?>});
	})

	function home_page(opts){
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

	home_page.prototype = {
		init: function(){
			const self = this;
			self.build_html();
		},
		build_html: function(){
			const self = this;
			self.$cont
			.append(
				self.build_header()
			)
			
		},
		build_header: function(){
			const self = this;
			const $header = $('<div>', {class: 'col-12'});
			
			$header
			.append(
				$('<section>', {class:''})
				.append(
					$('<nav>')
					.append(
						$('<img>', {src:'/~depsked/assets/images/logo.png'}),
						$('<div>', {class:'nav-links'})
						.append(
							$('<ul>')
							.append(
								$('<li>',{text:'HOME'}),
								$('<li>',{text:'CALENDAR'}),
								$('<li>',{text:'MANAGE COURSES'}),
								$('<li>',{text:'MANAGE PROFESSORS'})
							)
						)
					)
				)
			)
			return $header;
		}
	}
</script>
<body style="background-image: url('/~depsked/assets/images/banner.jpg');">
	<div id="page" class="container-fluid" >
		<div id="page_cont" class="row">
		</div>
	</div>
</body>