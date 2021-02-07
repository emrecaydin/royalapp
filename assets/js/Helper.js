class Helper {

  static isFalsy(value) {
    return value === '' || value === undefined || value === 'undefined' || value === null || value === 'NULL' || value === 'null'
  }

  static validateEmail(email) {
    const re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
    return re.test(email)
  }

  static dateFormater(date, isTurkishFormat = true, showTime = false) {
    let pureDate = new Date(date)
    let day = parseInt(pureDate.getDate()) < 10 ? '0' + pureDate.getDate() : pureDate.getDate()
    let month = parseInt(pureDate.getMonth()) + 1 < 10 ? '0' + (parseInt(pureDate.getMonth()) + 1) : pureDate.getMonth() + 1
    let year = pureDate.getFullYear()
    let time = ''
    if (showTime) {
      time = ' ' + (parseInt(pureDate.getHours()) < 10 ? '0' + pureDate.getHours() : pureDate.getHours()) + ':' + (parseInt(pureDate.getMinutes()) < 10 ? '0' + pureDate.getMinutes() : pureDate.getMinutes())
    }
    return isTurkishFormat ? day + '-' + month + '-' + year + time : year + '-' + month + '-' + day + time
  }

  static fillHourSelects() {
    let selectors = ['create-update-todoList-deadlineHour']
    selectors.map(selector => {
      let select = $('#' + selector)
      select.html('')
      select.append(`<option value="0">-</option>`)
      for (let i = 1; i < 24; i++) {
        select.append(`<option value="${i}">${i} saat</option>`)
      }
    })
  }

  static fillMinuteSelects() {
    let selectors = ['create-update-todoList-deadlineMinute']
    selectors.map(selector => {
      let select = $('#' + selector)
      select.html('')
      select.append(`<option value="0">-</option>`)
      for (let i = 10; i < 59; i += 5) {
        select.append(`<option value="${i}">${i} dakika</option>`)
      }
    })
  }

  static getToday(turkishDateFormat = false) {
    let date = new Date()
    let day = date.getDate() < 10 ? '0' + date.getDate() : date.getDate()
    let month = (date.getMonth() + 1) < 10 ? '0' + (date.getMonth() + 1) : (date.getMonth() + 1)
    let year = date.getFullYear()
    return turkishDateFormat ? day + '-' + month + '-' + year : year + '-' + month + '-' + day
  }

  static getCurrentYearMonth(turkishDateFormat = false) {
    let date = new Date()
    let month = (date.getMonth() + 1) < 10 ? '0' + (date.getMonth() + 1) : (date.getMonth() + 1)
    let year = date.getFullYear()
    return turkishDateFormat ? month + '-' + year : year + '-' + month
  }

  static getCurrentMonthName() {
    let months = Helper.getTurkishMonths()
    let date = new Date()
    let month = (date.getMonth() + 1) < 10 ? '0' + (date.getMonth() + 1) : (date.getMonth() + 1)
    return months[month.toString()]
  }

  static getTurkishMonths(type = 'object') {
    let months = {
      '01': 'Ocak',
      '02': 'Şubat',
      '03': 'Mart',
      '04': 'Nisan',
      '05': 'Mayıs',
      '06': 'Haziran',
      '07': 'Temmuz',
      '08': 'Ağustos',
      '09': 'Eylül',
      '10': 'Ekim',
      '11': 'Kasım',
      '12': 'Aralık'
    }

    if (type === 'array') {
      months = [
        { number: '01', name: 'Ocak' },
        { number: '02', name: 'Şubat' },
        { number: '03', name: 'Mart' },
        { number: '04', name: 'Nisan' },
        { number: '05', name: 'Mayıs' },
        { number: '06', name: 'Haziran' },
        { number: '07', name: 'Temmuz' },
        { number: '08', name: 'Ağustos' },
        { number: '09', name: 'Eylül' },
        { number: '10', name: 'Ekim' },
        { number: '11', name: 'Kasım' },
        { number: '12', name: 'Aralık' }
      ]
    }

    return months
  }

  static getStatus(statu) {
    let status = {
      created: 'Yeni Oluşturuldu',
      onCustomer: 'Müşteride Bekliyor',
      onProgress: 'İşlem Yapılıyor',
      closed: 'Kapandı'
    }
    if (status.hasOwnProperty(statu)) {
      return status[statu]
    }

    return 'İşlem Yapılıyor'
  }

  static getSource(source) {
    let sources = {
      CUSTOMER: 'Müşteri',
      AI: 'Yapay Zeka',
      USER: 'Personel',
      EMAIL: 'E-mail',
      PHONE: 'Telefon'
    }
    if (sources.hasOwnProperty(source)) {
      return sources[source]
    }

    return 'Müşteri'
  }

  static searchInList(searchInputId, searchPlaceId) {

    let value = $('#' + searchInputId).val().toLocaleUpperCase('tr-TR')
    if (value !== '') {
      $('#' + searchPlaceId + ' li').each(function () {
        let row = $(this)
        let text = row.find('span').text().toLocaleUpperCase('tr-TR')
        if (text.indexOf(value) === -1) {
          row.hide()
        } else {
          row.show()
        }
      })
    } else {
      $('#' + searchPlaceId + ' li').show()
    }
  }

  static searchInTable(searchInputId, searchPlaceId) {

    let value = $('#' + searchInputId).val().toLocaleUpperCase('tr-TR')
    if (value !== '') {
      $('#' + searchPlaceId + ' tbody tr').each(function () {
        let row = $(this)
        let text = row.find('td').text().toLocaleUpperCase('tr-TR')
        if (text.indexOf(value) === -1) {
          row.hide()
        } else {
          row.show()
        }
      })
    } else {
      $('#' + searchPlaceId + ' tbody tr').show()
    }
  }

  static setDatepicker(datePickerId, defaultDate = '') {

    $('#' + datePickerId).datepicker({
      dateFormat: 'dd-mm-yy',
      dayNames: ['Pazartesi', 'Salı', 'Çarşamba', 'Perşembe', 'Cuma', 'Cumartesi', 'Pazar'],
      dayNamesMin: ['Pzt', 'Sal', 'Çar', 'Per', 'Cum', 'Cmts', 'Paz'],
      dayNamesShort: ['Pzt', 'Sal', 'Çar', 'Per', 'Cum', 'Cmts', 'Paz'],
      monthNames: ['Ocak', 'Şubat', 'Mart', 'Nisan', 'Mayıs', 'Haziran', 'Temmuz', 'Ağustos', 'Eylül', 'Ekim', 'Kasım', 'Aralık']
    })

    if (defaultDate) {
      $('#' + datePickerId).datepicker('setDate', defaultDate)
    } else {
      $('#' + datePickerId).datepicker('setDate', '')
    }

  }

  static getLastDayOfMonth(year, month) {
    let date = new Date(year, month, 0)
    return date.getDate()
  }

  static setStartDateEndDate(startDateId, endDateId, needDefaultStartDate = true, needDefaultEndDate = true) {
    let date = new Date()
    let month = (date.getMonth() + 1) < 10 ? '0' + (date.getMonth() + 1) : (date.getMonth() + 1)
    let year = date.getFullYear()
    let startDefaultDate = needDefaultStartDate ? new Date(year, date.getMonth(), 1) : ''
    let lastDayOfMonth = Helper.getLastDayOfMonth(year, date.getMonth() + 1)
    let endDefaultDate = needDefaultEndDate ? new Date(year, date.getMonth(), lastDayOfMonth) : ''
    if (startDateId) {
      Helper.setDatepicker(startDateId, startDefaultDate)
    }
    if (endDateId) {
      Helper.setDatepicker(endDateId, endDefaultDate)
    }

  }

  static checkStartDateEndDate(startDateId, endDateId) {
    let startDateValue = $('#' + startDateId).datepicker('getDate')
    let endDateValue = $('#' + endDateId).datepicker('getDate')
    let date = new Date()
    let month = (date.getMonth() + 1) < 10 ? '0' + (date.getMonth() + 1) : (date.getMonth() + 1)
    let year = date.getFullYear()
    let lastDayOfMonth = Helper.getLastDayOfMonth(year, date.getMonth() + 1)
    let endDefaultDate = new Date(year, date.getMonth(), lastDayOfMonth)
    if (startDateValue > endDateValue) {
      Helper.setDatepicker(endDateId, endDefaultDate)
    }
  }

  static timeConverter(time) {
    let totalDays = (time / (24 * 60 * 60))
    let days = Math.floor(totalDays)
    let totalHours = (totalDays - days) * 60
    let hours = Math.floor(totalHours)
    let totalMinutes = (totalHours - hours) * 60
    let minutes = Math.floor(totalMinutes)

    let result = ''
    if (!Helper.isFalsy(days)) {
      result += days + ' gün '
    }

    if (!Helper.isFalsy(hours)) {
      result += hours + ' sa '
    }

    if (!Helper.isFalsy(minutes)) {
      result += minutes + ' dk '
    }

    return result ? result : 'SLA Hesaplama Hatası'
  }

  static toggleLoadingPage(status = 'show') {
    let loadingPageDivSelector = $('.loaderDivWrapper')
    status === 'show' ? loadingPageDivSelector.css({ 'display': 'flex' }) : loadingPageDivSelector.hide()
  }

  static toggleCheckedInput(selectorId, inputType = 'checkbox', checked = true) {
    if (checked === 'false') {
      checked = false
    }
    if (checked === 'true') {
      checked = true
    }
    $('#' + selectorId + ' input[type="' + inputType + '"]:checked').prop('checked', checked)
  }

  static fixHeader(selectorId, offset) {
    let selector = $(selectorId)
    if (window.pageYOffset > offset) {
      selector.addClass('sticky')
    } else {
      selector.removeClass('sticky')
    }
  }

  static alertMessage(message, show = 'true', messageType = 'danger', showTime = 3000) {
    if (!message) {
      return ''
    }
    let alertMessagesWrapperSelector = $('#alert-messages-wrapper')
    let messageWrapperDivSelector = $('#alert-' + messageType + '-message-div')
    let messageContentSpanSelector = $('#alert-' + messageType + '-message-content')
    alertMessagesWrapperSelector.find('div').hide()
    if (show) {
      messageContentSpanSelector.html(message)
      messageWrapperDivSelector.show()
    } else {
      messageContentSpanSelector.html('')
      messageWrapperDivSelector.hide()
    }
    setTimeout(() => {
      messageContentSpanSelector.html('')
      messageWrapperDivSelector.hide()
    }, showTime)
  }

  static numberFormat(number) {
    if (!number) {
      return false
    }

    let mainPart = number
    let floatPart = ''
    if (number.indexOf('.') !== -1) {
      let splitNumber = number.split('.')
      mainPart = splitNumber[0]
      floatPart = splitNumber[1]
    }

    let mainPartLength = mainPart.length
    let i = mainPartLength % 3
    let parts = i ? [mainPart.substr(0, i)] : []
    for (; i < mainPartLength; i += 3) {
      parts.push(mainPart.substr(i, 3))
    }

    return parts.join('.') + ',' + floatPart
  }

}

window.helper = Helper
module.exports = Helper
