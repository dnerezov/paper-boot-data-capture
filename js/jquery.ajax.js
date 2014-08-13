/**
* @description A class that handles ajax request
* @category  Library (HTTP)
* @package   Mvc Bobo
* @author    Denis Nerezov <dnerezov@gmail.com>
* @copyright (c) 2010 Denis Nerezov
* @link      http://bobo.org/license
*/
var Ajax =
{
    /**
    * View file params
    *
    * @var     object
    */
    params: {
        url: null,
        global: false,
        type: 'GET',
        cache: false,
        dataType: 'json',
        data: {}
        //selector: '#div',
        //complete: done
        //success: test
    },

    /**
    * Set root title (first node name)
    *
    * @param $value string.
    * @return void
    */
    construct: function (params) {
        this.overrideParams(params);

        return this.handle();
    },

    /**
    * Set root title (first node name)
    *
    * @param $value string.
    * @return void
    */
    overrideParams: function(params) {
        this.params = jQuery.extend.apply($, [this.params].concat(params));
    },

    /**
    * Set root title (first node name)
    *
    * @param $value string.
    * @return void
    */
    handle: function () {
        return jQuery.ajax(this.params);
    }
}