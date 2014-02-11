/*
 ***********************************************************/
/**
 * @name          : Joomla HD Video Share
 *** @version	  : 3.4.1
 * @package       : apptha
 * @since         : Joomla 1.5
 * @author        : Apptha - http://www.apptha.com
 * @copyright     : Copyright (C) 2011 Powered by Apptha
 * @license       : http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @abstract      : Contus HD Video Share Component htmltooltip.js file
 * @Creation Date : March 2010
 * @Modified Date : September 2013
 * */

/*
 ***********************************************************/

jQuery.noConflict();

var tipCount;
var langFlag;
var setFlag;
function htmltooltipCallback(tooltipclass,tipCount,langFlag){
  

    var htmltooltip={
            tipclass: tooltipclass,
            fadeeffect: [false, 500],
            anchors: [],
            tooltips: [], //array to contain references to all tooltip DIVs on the page

            positiontip:function($, tipindex, e){
                
                    var anchor=this.anchors[tipindex]
                    var tooltip=this.tooltips[tipindex]
                    var scrollLeft;
                    
                    scrollLeft = window.pageXOffset? window.pageXOffset : this.iebody.scrollLeft;
                    

                    var scrollTop=window.pageYOffset? window.pageYOffset : this.iebody.scrollTop
                    var docwidth=(window.innerWidth)? window.innerWidth-15 : htmltooltip.iebody.clientWidth-15
                    var docheight=(window.innerHeight)? window.innerHeight-18 : htmltooltip.iebody.clientHeight-15
                    var tipx=anchor.dimensions.offsetx
                    var tipy=anchor.dimensions.offsety+anchor.dimensions.h

                    
                    
                    tipx=(tipx+tooltip.dimensions.w-scrollLeft>docwidth)? tipx-tooltip.dimensions.w : tipx //account for right edge
                    
                    
                     //account for bottom edge

                    if(tipy+tooltip.dimensions.h-scrollTop > docheight){
                         tipy= tipy-tooltip.dimensions.h-anchor.dimensions.h;
                         $("#htmltooltipwrapper"+tipCount+tipindex).html(' <div class="chat-bubble-arrow-border1 "></div><div class="chat-bubble-arrow1"></div>');
                    }
                    else{
                         tipy= tipy
                         $("#htmltooltipwrapper"+tipCount+tipindex).html(' <div class="chat-bubble-arrow-border "></div><div class="chat-bubble-arrow"></div>');
                    }                  
                    
                    


                    if(!langFlag) {
                        $(tooltip).css({left: tipx, top: tipy})
                    }
                    else {
                        
                        $(tooltip).css({left: (tipx-175), top: tipy})
                    }
                    
                   

                    
            },

            showtip:function($, tipindex, e){
                    var tooltip=this.tooltips[tipindex]
                    if (this.fadeeffect[0])
                            $(tooltip).hide().fadeIn(this.fadeeffect[1])
                    else
                            $(tooltip).show()
            },

            hidetip:function($, tipindex, e){
                    var tooltip=this.tooltips[tipindex]
                    if (this.fadeeffect[0])
                            $(tooltip).fadeOut(this.fadeeffect[1])
                    else
                            $(tooltip).hide()
            },

            updateanchordimensions:function($){
                    var $anchors=$('a[rel="'+htmltooltip.tipclass+'"]')
                    $anchors.each(function(index){
                            
                        this.dimensions={w:this.offsetWidth, h:this.offsetHeight, offsetx:$(this).offset().left, offsety:$(this).offset().top}

                    })
            },

            render:function(){
                    jQuery(document).ready(function($){
                            htmltooltip.iebody=(document.compatMode && document.compatMode!="BackCompat")? document.documentElement : document.body
                            var $anchors=$('a[rel="'+htmltooltip.tipclass+'"]')
                            var $tooltips=$('div[class="'+htmltooltip.tipclass+'"]')
                            $anchors.each(function(index){ //find all links with "title=htmltooltip" declaration
                                
                                    
                                    this.dimensions={w:this.offsetWidth, h:this.offsetHeight, offsetx:$(this).offset().left, offsety:$(this).offset().top} //store anchor dimensions
                                    this.tippos=index+' pos' //store index of corresponding tooltip
                                    var tooltip=$tooltips.eq(index).get(0) //ref corresponding tooltip
                                    if (tooltip==null) //if no corresponding tooltip found
                                            return //exist
                                    tooltip.dimensions={w:tooltip.offsetWidth, h:tooltip.offsetHeight}
                                    $(tooltip).remove().appendTo('body') //add tooltip to end of BODY for easier positioning
                                    htmltooltip.tooltips.push(tooltip) //store reference to each tooltip
                                    htmltooltip.anchors.push(this) //store reference to each anchor
                                    var $anchor=$(this)
                                    $anchor.hover(
                                            function(e){ //onMouseover element
                                                    htmltooltip.positiontip($, parseInt(this.tippos), e)
                                                    htmltooltip.showtip($, parseInt(this.tippos), e)
                                            },
                                            function(e){ //onMouseout element
                                                    htmltooltip.hidetip($, parseInt(this.tippos), e)
                                            }
                                    )
                                    $(window).bind("resize", function(){htmltooltip.updateanchordimensions($)})
                            })
                    })
            }
    }

    htmltooltip.render();
    
}






