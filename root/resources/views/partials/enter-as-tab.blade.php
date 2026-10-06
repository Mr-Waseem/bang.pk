{{-- Enter key moves focus like Tab within invoice forms (.st-wrap / form). --}}
<script>
(function ($) {
    if (window.__stEnterAsTabBound) {
        return;
    }
    window.__stEnterAsTabBound = true;

    function isVisible(el) {
        return !!(el && (el.offsetWidth || el.offsetHeight || el.getClientRects().length));
    }

    function getRoot(fromEl) {
        var $from = $(fromEl);
        var $root = $from.closest('.st-wrap');
        if ($root.length) {
            return $root;
        }
        $root = $from.closest('form');
        if ($root.length) {
            return $root;
        }
        return $from.closest('.panel-body');
    }

    function collectFocusables($root) {
        var list = [];
        $root.find('input, select, textarea, button.btn-add-line').each(function () {
            var el = this;
            var $el = $(el);

            if ($el.is(':disabled') || $el.prop('disabled') || $el.is('[readonly]') || $el.prop('readonly')) {
                return;
            }
            if ($el.is('[type=hidden], [type=checkbox], [type=radio], [type=submit], [type=button]:not(.btn-add-line)')) {
                return;
            }
            if ($el.hasClass('select2-search__field') || $el.hasClass('st-readonly')) {
                return;
            }

            if ($el.hasClass('select2-hidden-accessible') || ($el.is('select') && $el.next('.select2').length)) {
                var sel = $el.next('.select2').find('.select2-selection').get(0);
                if (sel && isVisible(sel) && list.indexOf(sel) === -1) {
                    list.push(sel);
                }
                return;
            }

            if (!isVisible(el)) {
                return;
            }
            list.push(el);
        });
        return list;
    }

    function focusEl(el) {
        var $el = $(el);
        if ($el.hasClass('select2-selection')) {
            var $select = $el.closest('.select2').prev('select');
            try {
                $select.select2('open');
                setTimeout(function () {
                    var $search = $('.select2-container--open .select2-search__field');
                    if ($search.length) {
                        $search.focus();
                    } else {
                        $el.focus();
                    }
                }, 0);
            } catch (err) {
                $el.focus();
            }
            return;
        }
        try {
            el.focus();
            if ($el.is('input:not([type=date]), textarea')) {
                el.select();
            }
        } catch (err2) {}
    }

    function resolveCurrent(target) {
        var $t = $(target);
        if ($t.hasClass('select2-search__field')) {
            var $open = $('.select2-container--open').first();
            if ($open.length) {
                return $open.find('.select2-selection').get(0) || target;
            }
        }
        if ($t.closest('.select2-selection').length) {
            return $t.closest('.select2-selection').get(0);
        }
        return target;
    }

    function triggerAddLine($t) {
        if (typeof window.AddGridDataClick === 'function') {
            window.AddGridDataClick();
            return;
        }
        if (typeof window.AddGridData === 'function') {
            window.AddGridData();
            return;
        }
        var $btn = $t.closest('.btn-add-line');
        if (!$btn.length) {
            $btn = $('.btn-add-line').first();
        }
        if ($btn.length) {
            $btn.trigger('click');
        }
    }

    // Capture phase so this runs before older window/document Enter handlers
    document.addEventListener('keydown', function (e) {
        if (!(e.key === 'Enter' || e.keyCode === 13)) {
            return;
        }
        if (e.shiftKey || e.ctrlKey || e.altKey || e.metaKey) {
            return;
        }

        var target = e.target;
        var $t = $(target);

        if ($t.hasClass('select2-search__field') || $t.closest('.select2-results').length) {
            return;
        }
        if ($('.select2-container--open').length && $t.closest('.select2-container').length) {
            return;
        }

        if ($t.is('button[type=submit], input[type=submit]') ||
            ($t.is('button, input') && /save/i.test(($t.text() || $t.val() || '') + ' ' + ($t.attr('id') || '')))) {
            return;
        }

        if ($t.hasClass('btn-add-line') || $t.closest('.btn-add-line').length ||
            $t.is('#myTable tr.st-entry #amount')) {
            e.preventDefault();
            e.stopPropagation();
            triggerAddLine($t);
            return;
        }

        var $root = getRoot(target);
        if (!$root.length) {
            return;
        }

        var list = collectFocusables($root);
        if (!list.length) {
            return;
        }

        var current = resolveCurrent(target);
        var idx = list.indexOf(current);
        if (idx < 0) {
            for (var i = 0; i < list.length; i++) {
                if (list[i] === current || $(list[i]).is(current)) {
                    idx = i;
                    break;
                }
            }
        }
        if (idx < 0) {
            return;
        }

        e.preventDefault();
        e.stopPropagation();

        if (idx >= list.length - 1) {
            if ($(list[idx]).hasClass('btn-add-line') || $(list[idx]).closest('.btn-add-line').length) {
                triggerAddLine($(list[idx]));
            }
            return;
        }

        focusEl(list[idx + 1]);
    }, true);
})(jQuery);
</script>
