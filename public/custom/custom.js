window.onload = function () {
	document.querySelectorAll('.course-report-btn').forEach(function (element) {
		var courseReportId = $(element).attr('data-id')
		var fileName = $(element).attr('data-file-name')
		var modalContent = `
<div id="open-course-modal-${courseReportId}" data-is-opened-before="0"  class="modal-window opacity-0 vis-hidden pointer-none" >
  <div>
    <a onclick="return false;" href="#" title="Close" class="modal-close btn  btn-danger">اغلاق</a>
    <div class="append-export-table" style="margin-top:40px">
        برجاء الانتظار ...
    </div>
    <a href="#" class="btn btn-primary export-csv-btn display-none" target="_blank" style="display:block;margin-top:10px;" data-id="${courseReportId}" data-file-name="${fileName}" >

تصدير 
      </a>
  </div>
</div>
</div>`
		$(element).after(modalContent)


	})

}

$(document).on('click', '.course-report-btn', function (e) {
	e.preventDefault()
	const id = $(this).attr('data-id')
	const modal = $(this).parent().find('#open-course-modal-' + id)
	$(modal).removeClass(['vis-hidden', 'opacity-0', 'pointer-none'])
	const openedBefore = +$(modal).attr('data-is-opened-before')
	if (!openedBefore) {
		$.ajax({
			url: '/course-report/' + id,
			data: {},
			type: 'get',
			success: (res) => {
				if (!res.no_students) {
					$(modal).find('.append-export-table').empty().append('لا توجد بيانات حتى الان')
					return
				}
				$(modal).attr('data-is-opened-before', 1)
				let table = `<table class="table export-table" data-no-students="${res.no_students}" data-id="${res.id}"> <thead> <tr> <th> # </th> <th> الاسم </th> <th> الهاتف </th> <th>التاريخ</th> <th>حاله الدفع</th> </tr> </thead> <tbody> `
				let index = 1
				for (let user of res.users) {
					table += `<tr> <td class="export-value-element">  ${index}  </td> <td class="export-value-element"> ${user.name} </td> <td class="export-value-element"> ${user.phone} </td> <td class="export-value-element"> ${user.date} </td> <td class="export-value-element"> ${user.payment_status} </td> </tr>`

					index += 1
				}
				table += '</tbody></table>'
				$('.export-csv-btn[data-id="' + id + '"]').removeClass('display-none')
				$(modal).find('.append-export-table').empty().append(table)

			},
			error: function () { }
		})
	}

})
$(document).on('click', '.modal-close', function (e) {
	e.preventDefault()
	$(this).closest('.modal-window').addClass(['vis-hidden', 'opacity-0', 'pointer-none'])

})
$(document).on('click', '.export-csv-btn', function () {
	const id = $(this).attr('data-id')
	const fileName = $(this).attr('data-file-name')
	const noStudents = $(this).parent().find('table').attr('data-no-students')
	createCsvDynamic(id, fileName, noStudents)

})
function createCsvDynamic(id, fileName, noStudents) {
	let csv = $('.export-table[data-id="' + id + '"]').map((i, sample) => {
		return $(sample).find('.export-value-element').map((_, field) => field.innerText).get().join(',')
	}).get()
	csv.unshift('#,الاسم , رقم الهاتف , تاريخ الطلب , حاله الدفع') // add headers
	var courseName = fileName
	var courseNameTitle = 'اسم الدورة'
	var noStudentsTitle = 'عدد الطلاب '
	csv.unshift('' + ',' + '') // add headers
	csv.unshift(courseName + ',' + noStudents) // add headers
	csv.unshift(courseNameTitle + ',' + noStudentsTitle) // add headers
	createCsvFile(fileName, csv)



	function createCsvFile(fileName, csvArray) {
		let file = new Blob(["\uFEFF" + csvArray.join('\r\n')], {
			type: "application/csv; charset=utf-8"
		})
		fileName = "تقرير بطلاب دورة " + fileName
		let url = URL.createObjectURL(file)
		let a = $("<a />", {
			href: url,
			download: fileName + ".csv"
		}).appendTo("body").get(0).click()
	}
}
