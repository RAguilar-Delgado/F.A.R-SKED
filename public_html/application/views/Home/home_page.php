
<script>
	$(window).on('load', function(){
		new home_page({pageData:<?=$pageData?>});
	})

	function home_page(opts){
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

	home_page.prototype = {
		init: function(){
			const self = this;
			self.build_html();
		},
		build_html: function(){
			const self = this;
			self.$cont
			.append(
				self.build_header(),
				self.build_body(),
				self.build_cards()
			)
			
		},
		build_header: function(){
			const self = this;
			const $header = $('<div>', {class: 'col-12'});
			const $testBtn = $('<button>',{type:'button', class:'btn btn-primary mt-2', text:'Test'});

			$header
			.append(
				$('<div>', {class: 'w-100 rounded border-bottom font-weight-bold', text:'(F.A.R SKED) - Home', css: {color:'#5784A9', fontSize:'1.25rem'}}),
				$testBtn
			)
			$testBtn.on('click', function(){
				self.test_ajax();
			});
			return $header;
		},
		test_ajax: function(){
			const self = this;
			$.ajax({
				type:'POST',
				url:'/~depsked/Home/test_ajax',
				dataType: "json",
				data: [],
				success: function(d){

					if(d.error == 0){
						console.log(d);
					}
				},
				error: function( jqxhr, textStatus, error ){
					const err = textStatus + ", " + error;
					console.log( "Request Failed: " + err );
				}
			});
		},
		build_body: function(){
			
		},
		build_cards: function(){
			const $cont = $('<div>', {class: 'col-12'});
			const self = this;
			const $cards = [];
			self.define_cards();
			console.log(self.cards);

			for(let x in self.cards){
				const $card = self.build_card(x);
				$cards.push($card);
			}
			$cont.append(
				$('<div>',{class:'container-fluid w-100'})
				.append(
					$('<div>',{class:'row w-100'})
					.append(
						$cards
					)
				)
			)
			return $cont;
		},
		define_cards: function(){
			const self = this;
			self.cards = [];

			self.cards.push({label: 'Calendar Page', icon: 'fa-solid fa-calendar-days', color: '#063764', onClick:'/~depsked/Calendar/calendar_page'});
			self.cards.push({label: 'Manage Semesters', icon: 'fa-school', color: '#063764', onClick:'/ork/your_questions?defaultTab=3'});
			self.cards.push({label: 'Manage Professors', icon: 'fa-user-tie', color: '#063764', onClick:'/ork/your_questions?defaultTab=3'});
			self.cards.push({label: 'Manage Courses', icon: 'fa-clipboard-list', color: '#063764', onClick:'/ork/your_questions?defaultTab=3'});
		},

		build_card: function(cardID){
			const self = this;
			const card = self.cards.hasOwnProperty(cardID) ? self.cards[cardID] : false;
			card.color = '#a58329';

			if(card === false){
				return false;
			}

			const $cardCont = $('<div>', {class: 'col-3 py-3'})
			const $card = $('<div>', {class: 'card bg-light h-100 shadow-sm'});
			$cardCont
			.append(
				$card
				.append(
					$('<div>', {class: 'w-100 text-center mt-1'})
					.append(
						$('<i>', {class: 'fa mx-auto p-2', css: {fontSize: '10rem', color: card.color}})
						.addClass(card.icon)
					),
					$('<div>', {class: 'card-body text-center'})
					.append(
						$('<div>', {text: card.label, class: 'card-text font-weight-bold', css: {fontWeight: 'bold', fontSize: '2rem',  color:'#a58329'}})
					)
				)
			)

			if(card.hasOwnProperty('onClick')){
				$card.on('click', function(){
					window.location = card.onClick;
				})
			}

			return $cardCont;
		}
	}
</script>

<div id="login_page" class="container-fluid">
	<div id="login_cont" class="row">
	</div>
</div>