/**
 * Created by Administrator on 2017-01-07.
 */
'use strict'

import noty from 'noty'
import $ from 'jquery'

let Notify = function () {

}

Notify.prototype.show = function (type, message, options = {}) {

    let content = '';
    Object.keys(message).map(function(key, index) {
        var value =message[key];
        content += '<span>' + value[0] + '</span><br>';
    });
    let payload = {
        type,
        text: content,
        timeout: 3000,
        layout: 'topCenter',
        theme:'relax'
    }

    return noty($.extend(payload, options))
}

let helpers = ['alert', 'error', 'success', 'info', 'warning']
helpers.forEach(helper => {
    Notify.prototype[helper] = function (message, options = {}) {
        return this.show(helper, message, options)
    }
})

Notify.install = function (Vue, options) {
    Vue.notify = new Notify()
    Object.defineProperties(Vue.prototype, {
        $notify: {
            get () {
                return Vue.notify
            }
        }
    })
}

export default Notify