define([],function(){function t(n){if(!(this instanceof t)&&s(n))return r(n)}function n(n){var r,o;for(r in n)o=n[r],t.Mutators.hasOwnProperty(r)?t.Mutators[r].call(this,o):this.prototype[r]=o}function r(r){return r.extend=t.extend,r.implement=n,r}function o(){}function i(t,n,r){for(var o in n)if(n.hasOwnProperty(o)){if(r&&p(r,o)===-1)continue;"prototype"!==o&&(t[o]=n[o])}}t.create=function(o,e){function u(){o.apply(this,arguments),this.constructor===u&&this.initialize&&this.initialize.apply(this,arguments)}return s(o)||(e=o,o=null),e||(e={}),o||(o=e.Extends||t),e.Extends=o,o!==t&&i(u,o,o.StaticsWhiteList),n.call(u,e),r(u)},t.extend=function(n){return n||(n={}),n.Extends=this,t.create(n)},t.Mutators={Extends:function(t){var n=this.prototype,r=e(t.prototype);i(r,n),r.constructor=this,this.prototype=r,this.superclass=t.prototype},Implements:function(t){c(t)||(t=[t]);for(var n,r=this.prototype;n=t.shift();)i(r,n.prototype||n)},Statics:function(t){i(this,t)}};var e=Object.__proto__?function(t){return{__proto__:t}}:function(t){return o.prototype=t,new o},u=Object.prototype.toString,c=Array.isArray||function(t){return"[object Array]"===u.call(t)},s=function(t){return"[object Function]"===u.call(t)},p=Array.prototype.indexOf?function(t,n){return t.indexOf(n)}:function(t,n){for(var r=0,o=t.length;r<o;r++)if(t[r]===n)return r;return-1};return t});