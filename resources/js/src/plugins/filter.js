import Vue from 'vue'
import dayjs from 'dayjs'

Vue.filter('readmore', val => {
    if(!val) return ''
    val = val.replace(/\s{2,}/g, ' ')
    const strLength = val.length
    if(strLength > 24) {{
      val = val.slice(0, 23) + '...'}

    }
    return val.toLowerCase()
    .replace(/\w/, firstLetter => firstLetter.toUpperCase())
})

Vue.filter('formatPrice', value => {
    if(!value) return 0
    let val = (value/1).toFixed(0).replace(',', '.')
    return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
})

Vue.filter('lowercase', val => {
  if(!val) return ''
  return val.toLowerCase()
})

Vue.filter('uppercase', val => {
    if(!val) return ''
    return val.toUpperCase()
})

Vue.filter('formatDate', value => {
  if (value) {
    return dayjs(String(value)).format('DD-MM-YYYY HH:mm:ss')
  }
  return '-'
})

Vue.filter('subtractDate', value => {
  if (value) {
    return dayjs(String(value)).subtract(1, 'hour').format('MM-DD-YYYY HH:mm:ss')
  }
  return '-'
})

Vue.filter('formatDateString', value => {
  if (value) {
    return dayjs(String(value)).format('DD-MMM-YYYY HH:mm:ss')
  }
  return '-'
});

Vue.filter('formatPriceWithDecimal', value => {
    if(!value) return 0
    let val = (value/1).toFixed(2).replace(',', '.')
    return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
})

Vue.filter('convertCountryCode', value => {
    console.log('convertcountrycode')
    if (value === 'cn') {
        return 'China'
    }
    if (value === 'th') {
        return 'Thailand'
    }
    if (value === 'id') {
        return 'Indonesia'
    }
    return '-'
})

Vue.filter('underscore', val => {
    if(!val) return ''
    return val.replace(/_/g, ' ')
})

Vue.filter('getShortName', val => {
    var matches = val.match(/\b(\w)/g); // ['J','S','O','N']
    var acronym = matches.join(''); // JSON
    return acronym.toUpperCase()
})

Vue.filter('labelByStatus', val => {
    if (val === 'approved') return "badge badge-success rounded-pill";
    if (val === 'rejected') return "badge badge-danger rounded-pill";
    if (val === 'published') return "badge badge-primary rounded-pill";
    if (val === 'requested') return "badge badge-warning rounded-pill";
})