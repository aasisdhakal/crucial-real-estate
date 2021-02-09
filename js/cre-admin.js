(function ($) {
    "use strict";

    $(document).ready(function() {

        // Script for Additional Social Networks
        var fontsLink = '<div><a href="https://fontawesome.com/icons?d=gallery&m=free" target="_blank">' + ereSocialLinksL10n.iconLink + '</a></div>';
        $(document).on("click", "#aarambha-cre-add-sn", function (event) {
            var socialNetworksTable = $('#aarambha-cre-social-networks-table');
            var socialNetworkIndex = socialNetworksTable.find('tbody tr').last().index() + 1;
            var socialNetwork =
                '<tr class="aarambha-cre-sn-tr">' +
                '<th scope="row">' +
                '<label for="aarambha-cre-sn-title-' + socialNetworkIndex + '">' + ereSocialLinksL10n.title + '</label>' +
                '<input type="text" id="aarambha-cre-sn-title-' + socialNetworkIndex + '" name="aarambha_cre_social_networks[' + socialNetworkIndex + '][title]" class="code">' +
                '</th>' +
                '<td>' +
                '<div>' +
                '<label for="aarambha-cre-sn-url-' + socialNetworkIndex + '"><strong>' + ereSocialLinksL10n.profileURL + '</strong></label>' +
                '<input type="text" id="aarambha-cre-sn-url-' + socialNetworkIndex + '" name="aarambha_cre_social_networks[' + socialNetworkIndex + '][url]" class="regular-text code">' +
                '</div>' +
                '<div>' +
                '<label for="aarambha-cre-sn-icon-' + socialNetworkIndex + '"><strong>' + ereSocialLinksL10n.iconClass + '</strong> <small>- <em>' + ereSocialLinksL10n.iconExample + '</em></small></label>' +
                '<input type="text" id="aarambha-cre-sn-icon-' + socialNetworkIndex + '" name="aarambha_cre_social_networks[' + socialNetworkIndex + '][icon]" class="code">' +
                '<a href="#" class="aarambha-cre-remove-sn aarambha-cre-sn-btn">-</a>' +
                fontsLink +
                '</div>' +
                '</td>' +
                '</tr>';

            socialNetworksTable.append(socialNetwork);
            event.preventDefault();
        });

        $(document).on("click", ".aarambha-cre-remove-sn", function (event) {
            $(this).closest('.aarambha-cre-sn-tr').remove();
            event.preventDefault();
        });

        $(document).on("click", ".aarambha-cre-edit-sn", function (event) {
            var $this = $(this),
                tableRow = $this.closest('.aarambha-cre-sn-tr');
            tableRow.find('.aarambha-cre-sn-field').removeClass('hide');
            tableRow.find('.aarambha-cre-sn-title').hide();
            $this.siblings('.aarambha-cre-update-sn').removeClass('hide');
            $this.addClass('hide');
            event.preventDefault();
        });

        $(document).on("click", ".aarambha-cre-update-sn", function (event) {
            var $this = $(this),
                tableRow = $this.closest('.aarambha-cre-sn-tr');
            tableRow.find('.aarambha-cre-sn-field').addClass('hide');
            tableRow.find('.aarambha-cre-sn-title').show().html(tableRow.find('input[type="text"]').val());
            $this.siblings('.aarambha-cre-edit-sn').removeClass('hide');
            $this.addClass('hide');
            event.preventDefault();
        });

        /**
         * Adds formatted price preview on price fields in Property MetaBox.
         *
         * @since 0.6.0
         */
        function erePricePreview(element) {
            var $element = $(element),
                $price = $.trim($element.val()),
                $parent = $element.parent('.rwmb-input'),
                locale = $('html').attr('lang'),
                formatter = new Intl.NumberFormat(locale);

            $parent
                .css('position', 'relative')
                .append('<strong class="cre-price-preview"></strong>');

            var $preview = $parent.find('.cre-price-preview');

            if ($price) {
                $price = formatter.format($price);

                if ('NaN' !== $price && '0' !== $price) {
                    $preview.addClass('overlap').text($price);
                }
            }

            $element.on('input', function () {
                var price = $.trim($(this).val());

                price = formatter.format(price);
                if ('NaN' === price || '0' === price) {
                    $preview.text('');
                } else {
                    $preview.text(price);
                }
            });

            $element.on('focus', function () {
                $preview.removeClass('overlap');
            });

            $element.on('blur', function () {
                $preview.addClass('overlap');
            });

            $preview.on('click', function () {
                $element.focus();
            });
        }

        erePricePreview('#REAL_HOMES_property_price');
        erePricePreview('#REAL_HOMES_property_old_price');
    });
}(jQuery));