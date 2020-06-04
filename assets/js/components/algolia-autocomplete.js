import $ from 'jquery';
import 'autocomplete.js/dist/autocomplete.jquery';
import '../../css/components/_algolia-autocomplete.scss';

export default function($elements, dataKey, displayKey) {
    $elements.each(function () {
        let autocompleteUrl = $(this).data('autocomplete-url');
        $(this).autocomplete({hint: false}, [
            {
                source: function(query, cb) {
                    $.ajax(
                        autocompleteUrl+'?query='+query
                    ).then(function (data) {
                        if (dataKey) {
                            data = data[dataKey]
                        }
                        cb(data)
                    })
                },
                displayKey: displayKey,
                debounce: 500 // only request every 1/2 second
            }
        ]);
    })
}
