<meta name="viewport" content="with=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/~depsked/assets/stylesheets/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@700&display=swap" rel="stylesheet">
<script>
	$(window).on('load', function(){
		new calendar_page({pageData:<?=$pageData?>});
	})

	function calendar_page(opts){
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

	calendar_page.prototype = {
		init: function(){
			const self = this;
			self.arbitraryDate = '1001-01-01';
			self.filterData = {
				semesterID : 0,
				professorID : 0,
				buildingID : 0,
				roomID : 0
			}
			self.build_html();
		},
		build_html: function(){
			const self = this;
			self.$cont
			.append(
				self.build_header(),
				self.build_filters(),
				self.init_prof_notes(),
				self.init_manage_classes(),
				self.init_calendar()
			)	
		},
		build_header: function(){
			const self = this;
			const $header = $('<div>', {class: 'col-12 text-white'});
			self.$pageHeader = $('<h1>',{text:'Calendar', class:'w-100 text-center mb-0'});
			
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
				),
				self.$pageHeader
			)
			return $header;
		},
		build_filters: function(){
			const self = this;
			self.roomSelectNoBuildingData = self.flatten_select_data(self.pageData.roomSelect);
			const $cont = $('<div>', {class: 'col-12'});
			self.$filtersCont = $('<div>', {class:'row'});
			self.$semesterSelect = self.build_select(self.pageData.semesterSelect, true, 'build_calendar');
			self.$professorSelect = self.build_select(self.pageData.professorSelect, true, 'build_calendar');
			self.$roomSelectNoBuilding = self.build_select(self.roomSelectNoBuildingData, true, 'build_calendar');
			self.$buildingSelect = self.build_select(self.pageData.buildingSelect, true, 'rebuild_room_select');
			$cont
			.append(
				$('<div>',{class:'container-fluid'})
				.append(
					self.$filtersCont
					.append(
						$('<div>', {class: 'col-6'})
						.append(
							$('<span>', {class:'w-100 text-white', text:'Semester'}),
							self.$semesterSelect
						),
						$('<div>', {class: 'col-6'})
						.append(
							$('<span>', {class:'w-100 text-white', text:'Professor'}),
							self.$professorSelect
						),
						$('<div>', {class: 'col-6'})
						.append(
							$('<span>', {class:'w-100 text-white', text:'Building'}),
							self.$buildingSelect
						),
						$('<div>', {id:'room_select_cont', class: 'col-6'})
						.append(
							$('<span>', {class:'w-100 text-white', text:'Room'}),
							self.$roomSelectNoBuilding
						),
						
					)
				)
			);

			return $cont;
		},
		rebuild_room_select: function(){
			const self = this;
			const buildingID = self.$buildingSelect.val();
			const $roomSelectCont = $('#room_select_cont');
			$roomSelectCont.empty();

			if(buildingID > 0){
				self.$roomSelectNoBuilding.val(0);
				self.$roomSelectWithBuilding = self.build_select(self.pageData.roomSelect[buildingID], true, 'build_calendar');
				$roomSelectCont
				.append(
					$('<span>', {class:'w-100 text-white', text:`Room (${self.pageData.buildingSelect[buildingID].title})`}),
					self.$roomSelectWithBuilding
				)
			} else {
				self.$roomSelectWithBuilding.val(0);
				$roomSelectCont
				.append(
					$('<span>', {class:'w-100 text-white', text:'Room'}),
					self.$roomSelectNoBuilding
				)
			}
			self.build_calendar();
		},
		init_prof_notes: function(){
			const self = this;
			$cont = $('<div>', {class: 'col-6'});
			self.$professorNotesCont = $('<div>', {class:'col-12 pr-0'});
			$cont
			.append(
				$('<div>', {class:'container-fluid w-100'})
				.append(
					$('<div>', {class:'row'})
					.append(
						self.$professorNotesCont
					)
				)
			)

			return $cont;
		},
		build_professor_notes: function(){
			const self = this;
			self.$professorNotesCont.empty();
			const professorID = parseInt(self.$professorSelect.val());
			if(!professorID > 0){
				return;
			}
			const $cont = $('<div>',{class:'w-100'});
			self.$professorNotes = $('<textarea>',{class:'w-100', text:self.calendarData.ProfessorNotes});
			$cont
			.append(
				$('<div>',{class:'w-100'})
				.append(
					$('<span>', {class:'text-white', text:'Professor Notes'})
				),
				self.$professorNotes
			)
			self.$professorNotesCont
			.append(
				$cont
			)
		},
		init_manage_classes: function(){
			const self = this;
			$cont = $('<div>', {class: 'col-6'});
			self.$manageClassesCont = $('<div>', {class:'col-12 pl-0'});
			$cont
			.append(
				$('<div>', {class:'container-fluid w-100'})
				.append(
					$('<div>', {class:'row'})
					.append(
						self.$manageClassesCont
					)
				)
			)

			return $cont;
		},
		build_manage_classes: function(){
			const self = this;
			self.$manageClassesCont.empty()
			const roomID = parseInt(self.filterData.roomID);
				if(!roomID > 0){
					return;
				}
			const $cont = $('<div>',{class:'container-fluid p-0'});
			self.$courseSelect = self.build_select(self.calendarData.Courses, true, 'build_manage_class', 'CourseID', 'CourseDisplayName');
			self.$manageClassCont = $('<div>', {id:'test', class: 'col-12'});
			self.$numMeetingsSelectCont = $('<div>',{class:'col-6'});

			$cont
			.append(
				$('<div>', {class:'row'})
				.append(
					$('<div>', {class: 'col-6'})
					.append(
						$('<span>', {class:'w-100 text-white', text:'Courses'}),
						self.$courseSelect
					),
					self.$numMeetingsSelectCont,
					self.$manageClassCont
				)
			)
			self.$manageClassesCont
			.append(
				$cont
			)
		},
		build_num_meetings_select: function(){
			const self = this;
			self.$numMeetingsSelect = self.build_select(self.week, true, 'build_manage_class_meetings', 'sort', 'sort');
			self.$numMeetingsSelectCont
			.empty()
			.append(
				$('<span>', {class:'w-100 text-white', text:'Weekly Meetings'}),
				self.$numMeetingsSelect
				.on('change', function(){
					const course = self.calendarData.Courses[courseID];
					console.log(course);
					const numMeetings = self.$numMeetingsSelect.val();
					const minsPerMeeting = parseInt(course.MinLength) / parseInt(numMeetings);
					console.log(numMeetings)
					$('.duration').val(minsPerMeeting);
				})
			)	
		},
		build_manage_class: function(){
			const self = this;
			const $cont = $('<div>', {class:'container-fluid px-0'});
			self.build_num_meetings_select();
			self.$manageClassMeetingsCont = $('<div>', {class:'col-12 d-flex justify-content-start'});

			$cont
			.append(
				$('<div>', {class:'row'})
				.append(
					self.$manageClassMeetingsCont
				)
			)
			self.$manageClassCont.empty().append($cont);	
		},
		build_manage_class_meetings: function(){
			const self = this;
			const $doms = [];
			const numMeetings = self.$numMeetingsSelect.val();
			const domWidthPercent = 100 / numMeetings;
			for(let i = 1; i <= numMeetings; i++){
				const $dom = $('<div>', {class:'rounded mt-2 p-1 bg-white', css:{width:`${domWidthPercent}%`}});
				if(i != numMeetings){
					$dom.addClass('mr-1');
				}
				const $manualSelectBtn = $('<input>', {type:'checkbox', class:'checkBoxNonCheck'})
				.on('click', function(){
					const cls = $(this).attr('class');
					$(this).removeClass(cls)
					$('.checkBoxCheck').prop('checked', false).removeClass('checkBoxCheck').addClass('checkBoxNonCheck');

					if(cls == 'checkBoxNonCheck'){
						$(this).addClass('checkBoxCheck')
						$('.week-day-row').css('z-index', 4).css('pointer-events','');
					} else {
						$(this).addClass('checkBoxNonCheck')
						$('.week-day-row').css('z-index', 1).css('pointer-events','none');
					}
				});
				const $duration = $('<input>',{class:'w-100 duration', type:'text'});
				const $sTime = $('<input>',{class:'mt-1',type:'time', min:"09:00", max:"18:00"});
				const $daySelect = self.build_select(self.week, true, false, 'key', 'day');

				$dom
				.append(
					$('<span>', {class:'w-100', text:'Manual Select'}),
					$('<div>', {class:'w-100'})
					.append(
						$manualSelectBtn,
						$('<i>', {class:'fa fa-solid fa-arrow-pointer'})
					),
					$('<span>', {class:'w-100', text:'Minutes'}),
					$duration,
					$('<span>', {class:'w-100', text:'Day'}),
					$daySelect,
					$('<span>', {class:'w-100', text:'Start Time'}),
					$sTime
				)
				$doms.push($dom);
			}
			self.$manageClassMeetingsCont.empty().append($doms);
		},
		init_calendar: function(){
			const self = this;
			$cont = $('<div>', {class: 'col-12'});
			self.$calendarCont = $('<div>', {class:'col-12 mt-2'});
			$cont
			.append(
				$('<div>', {class:'container-fluid w-100'})
				.append(
					$('<div>', {class:'row'})
					.append(
						self.$calendarCont
					)
				)
			)

			self.week = {
				M : {sort:1, day:'Monday', key:'M'},
				T : {sort:2, day:'Tuesday', key:'T'},
				W : {sort:3, day:'Wednesday', key:'W'},
				Th : {sort:4, day:'Thursday', key:'Th'},
				F : {sort:5, day:'Friday', key:'F'}
			};

			self.build_calendar();
			return $cont;
		},
		build_calendar: async function(){
			const self = this;
			self.$calendarCont.empty()

			if(self.$semesterSelect.val() == 0){
				self.$pageHeader.text('Calendar')
				self.$calendarCont
				.append(
					$('<h3>',{text:'No filters selected.', class:'w-100 text-center'})
				)
				return
			}
			self.$calendarCont
			.append(
				$('<div>', {class:'w-100 text-center'})
				.append(
					$('<i>',{class:'fa fa-spinner fa-spin fa-fw text-white', css:{fontSize:'2rem'}})
				)	
			)
			await self.get_calendar_data();

			if(self.calendarData.hasOwnProperty('SemesterData') && self.calendarData.SemesterData.Semester){
				self.$calendarCont.empty();
				self.$pageHeader.text(`Calendar (${self.calendarData.SemesterData.Semester})`);
				self.build_cal_table();
			}
				// self.hard_code_class_meetings()
			self.build_class_meetings();


		},
		build_cal_table: function(){
			const self = this;
		
			self.$calTable = $('<div>',{class:'w-100'});
			self.build_cal_table_header();
			self.build_cal_table_body();
			self.$calendarCont.append(self.$calTable);
			self.build_cal_table_time_blocks();	
		},
		build_cal_table_header: function(){
			const self = this;
			const week = self.week;
			const $tHead = $('<div>', {class:'w-100 d-flex'});
			const $doms = [];

			for(let x in week){
				weekDay = week[x];
				day = weekDay.day;
				sort = weekDay.sort;
				const $weekHeader = $('<div>',{id:`week-header-${day}`,class:'text-white text-center', text:day, css:{width:'20%'}});
				$doms[sort] = $weekHeader
			}
			$tHead.append(
				$doms
			)
			self.$calTable.append($tHead);
		},
		build_cal_table_body: function(){
			const self = this;
			self.rows = self.get_total_cal_rows();
			self.rowHeightPx = 10;
			const calBodyHeightPx = self.rowHeightPx * self.rows.numRows;
			self.$calTableBody = $('<div>',{class:'w-100 d-flex rounded my-2', css:{'transform-style':'preserve-3d', position:'relative','z-index':'0', height:`${calBodyHeightPx}px`, backgroundColor:'rgb(255,255,255,.5)'}});
			self.build_cal_table_days();
			self.$calTable.append(
				self.$calTableBody
			)
		},
		build_cal_table_days: function(){
			const self = this;
			const week = self.week;

			for(let x in week){
				const weekDay = week[x];
				self.$calTableBody
				.append(
					self.build_cal_table_day(weekDay)
				)
			}	
		},
		build_cal_table_day: function(weekDay){
			const self = this;
			const rows = self.rows;

			const $col = $('<div>',{class:'h-100',id:`week-col-${weekDay.day.toLowerCase()}`, css:{position:'relative', 'z-index':'0', width:'20%'}});
			if(weekDay.day != 'Friday'){
				$col.addClass('border-right border-white')
			}
			const $doms = [];
			let cls = 'td';

			let curentTime = moment(rows.sTime);

			for(let x = 0; x <= rows.numRows; x++){
				const curTimeText = curentTime.format('hmma');
				const $fiveMinRow = $('<div>',{id:`week-day-row-${weekDay.day.toLowerCase()}-${curTimeText}`,class:'w-100 week-day-row', html:'&nbsp', css:{cursor:'pointer', height:`${self.rowHeightPx}px`, position:'relative', 'z-index':'2', 'pointer-events':'none'}})
				const $toolTip = $('<span>',{class:'rounded bg-light p-2', text: curentTime.format('h:mm A'), css:{display:'none', position:'absolute', right:'-2px', bottom:'-18px'}});

				$col.append(
					$fiveMinRow
					.append(
						$toolTip
					)
					
				)
				curentTime = curentTime.add(5, 'minutes');

				$fiveMinRow
				.on('click', function(){
					console.log('this got clicked', curTimeText);
				})
				.hover(function(){
					$(this).css('border-top','1px solid white');
					$toolTip.show();

				},
				function(){
					$(this).css('border-top','')
					$toolTip.hide();
				})
			}

			return $col;
		},
		get_total_cal_rows: function(){
			const self = this;
			const timeBlocks = self.calendarData.SemesterData.TimeBlockJSON;
			let calSTime = '';
			let calETime = '';

			for(let x in timeBlocks){
				const row = timeBlocks[x];
				const earliest = moment(`${self.arbitraryDate} ${self.convert_12_to_24_time(row[0].STime)}`);
				const latest = moment(`${self.arbitraryDate} ${self.convert_12_to_24_time(row[row.length - 1].ETime)}`);
				calSTime = calSTime == '' || earliest.isBefore(calSTime) ? earliest : calSTime;
				calETime = calETime == '' || latest.isAfter(calETime) ? latest : calETime;
			}

			const duration = moment.duration(calETime.diff(calSTime));
			const numRows = duration.asMinutes() / 5;

			return {'numRows': numRows, 'sTime' : calSTime, 'eTime' : calETime};
		},
		convert_12_to_24_time: function(time12h){
			const [time, modifier] = time12h.split(' ');
			let [hours, minutes] = time.split(':');

			if (hours === '12') {
			hours = '00';
			}

			if (modifier === 'pm') {
			hours = parseInt(hours, 10) + 12;
			}
			
			return `${hours}:${minutes}`;
		},
		build_cal_table_time_blocks: function(){
			const self = this;
			const week = self.week;
			const timeBlockSchedules = self.calendarData.SemesterData.TimeBlockJSON;

			for(let x in week){
				const weekDay = week[x];
				const day = weekDay.day;
				const $weekCol = $(`#week-col-${day.toLowerCase()}`);
				const timeBlockSchedule = timeBlockSchedules[x];

				for(let x in timeBlockSchedule){
					const timeBlock = timeBlockSchedule[x];
					const sTime = moment(`${self.arbitraryDate} ${self.convert_12_to_24_time(timeBlock.STime)}`);
					const eTime = moment(`${self.arbitraryDate} ${self.convert_12_to_24_time(timeBlock.ETime)}`);

					//dont need to calc the time!
				/*	const startOffsetDuration = moment.duration(sTime.diff(self.rows.sTime));
					const startOffsetPx = ((startOffsetDuration.asMinutes() / 5) * self.rowHeightPx);*/
					const classDuration = moment.duration(eTime.diff(sTime));
					const numRows = classDuration.asMinutes() / 5;
					const selector = `#week-day-row-${day.toLowerCase()}-${sTime.format('hmma')}`;
					const $startRow = $(selector);
					const startOffsetPx = $startRow.position().top;
					const width = $startRow.width();
					const heightPx = numRows * self.rowHeightPx;
					const $timeBlock = $('<div>',{class:'', html:'&nbsp', css:{width:width, height:`${heightPx}px`, position:'absolute',top:startOffsetPx, 'border-top':'2px solid black', 'pointer-events':'none', 'z-index':'1'}});
					$weekCol
					.append(
						$timeBlock
					)
					/*console.log($(`#week-day-row-${day}-${sTime.format('hmma')}`), numRows,sTime.format('h:mm A'), eTime.format('h:mm A'));*/
				}

			}
		},
		build_class_meetings:function(){
			const self = this;
			const classes = self.calendarData.Classes;

			for(let x in classes){
				classMeeting = classes[x];
				const course = self.calendarData.Courses[classMeeting.CourseID];
				const $startingTimeRow = $(`#week-day-row-${classMeeting.Day.toLowerCase()}-${course.STime.replace(':','')}`);
				
			}

		},
		hard_code_class_meetings:function(){
			const self = this;
			const pos1 = $('#week-day-row-monday-730am').position().top;
			const height = 10 * self.rowHeightPx;
			$(`#week-col-monday`)
			.append(
				$('<div>',{class:'rounded', css:{width:'90%', height:height, 'z-index':'3',position:'absolute', top:pos1, backgroundColor:'#ffcc00'}})
				.append(
					$('<div>',{class:'w-100 p-2 text-black', text:"358-A Software Design and Development"}),
					$('<div>',{class:'w-100 p-2 text-black', text:"7:30am - 8:20am"}),
				)
			)
			$(`#week-col-wednesday`)
			.append(
				$('<div>',{class:'rounded', css:{width:'90%', height:height, 'z-index':'3',position:'absolute', top:pos1,backgroundColor:'#ffcc00'}})
				.append(
					$('<div>',{class:'w-100 p-2 text-black', text:"358-A Software Design and Development"}),
					$('<div>',{class:'w-100 p-2 text-black', text:"7:30am - 8:20am"}),
				)
			)
			$(`#week-col-friday`)
			.append(
				$('<div>',{class:'rounded', css:{width:'90%', height:height, 'z-index':'3', position:'absolute', top:pos1, backgroundColor:'#ffcc00'}})
				.append(
					$('<div>',{class:'w-100 p-2 text-black', text:"358-A Software Design and Development"}),
					$('<div>',{class:'w-100 p-2 text-black', text:"7:30am - 8:20am"}),
				)
			)
			
		},
		get_calendar_data: function(){
			const self = this;
			self.filterData = {
				semesterID : self.$semesterSelect.val(),
				professorID : self.$professorSelect.val(),
				buildingID : self.$buildingSelect.val()
			}
			self.filterData.roomID = self.filterData.buildingID > 0 ? self.$roomSelectWithBuilding.val() : self.$roomSelectNoBuilding.val();
			return $.getJSON("/~depsked/Calendar/get_calendar_data", self.filterData, function(d){
				self.calendarData = d;
				self.build_professor_notes();
				self.build_manage_classes();
			})
		},
		build_select: function(optionsData, blankOption = false, onChange = false, customVal = false, customText = false){
			const self = this;

			$field = $('<select>', {class:'form-control'});
				const options = [];
				if(blankOption){
					options.push($('<option>', {text:'Select', val:0}));
				}
				const valKey = customVal ? customVal : 'val';
				const textKey = customText ? customText : 'text';
				if(optionsData){
					for(let x in optionsData){
						const opt = optionsData[x];
						options.push(
							$('<option>', {text:opt[textKey], val:opt[valKey]})
						)
					}
				}

				$field
				.append(
					options
				);

				if(onChange){
					$field.on('change', function(){
						self[onChange]($field.val());
					});
				}

				return $field;
		},
		flatten_select_data: function(selectData){
			const self = this;
			const newOps = {};

			for(let x in selectData){
				const row = selectData[x];
				if(typeof row[Object.keys(row)[0]] === 'object' && !row.hasOwnProperty('val') && !row.hasOwnProperty('text')){
					const flatData = self.flatten_select_data(row)
					for(let x in flatData){
						const flatrow = flatData[x];
						newOps[flatrow.val] = flatrow;
					}
				} else {
					newOps[row.val] = row;
				}	
			}
			return newOps;
		}
	}
</script>

<body style="background-image: linear-gradient(rgba(4, 9, 30, 0.7), rgba(4, 9, 30, 0.7)), url('/~depsked/assets/images/banner.jpg');">
	<div id="page" class="container-fluid" >
		<div id="page_cont" class="row">
		</div>
	</div>
</body>