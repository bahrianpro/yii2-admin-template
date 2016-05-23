/**
 * Admin theme JS hooks.
 */

(function ($) {
    'use strict';
    
    var Cookie = {
        write: function (name, value, days) {
            var expires;
            
            if (days) {
                var date = new Date();
                date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
                expires = "; expires=" + date.toGMTString();
            } else {
                expires = "";
            }
            
            document.cookie = encodeURIComponent(name) + "=" + encodeURIComponent(value) + expires + "; path=/";
        },
        
        read: function () {
            var nameEQ = encodeURIComponent(name) + "=",
                ca = document.cookie.split(';');
                
            for (var i = 0; i < ca.length; i++) {
                var c = ca[i];
                while (c.charAt(0) === ' ') {
                    c = c.substring(1, c.length);
                }
                if (c.indexOf(nameEQ) === 0) {
                    return decodeURIComponent(c.substring(nameEQ.length, c.length));
                }
            }
            
            return null;
        },
        
        delete: function (name) {
            this.write(name, '', -1);
        }
    };
    
    function init() {
        // Keep state of sidebar in cookie.
        if ($.AdminLTE.options.sidebarPushMenu) {
            $(document).on('collapsed.pushMenu', function (e) {
                Cookie.write('SidebarPushMenu', 'collapsed');
            });
            $(document).on('expanded.pushMenu', function (e) {
                Cookie.delete('SidebarPushMenu');
            });
        }
    }
    
    $(init);
    
}(jQuery));
