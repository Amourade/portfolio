"use strict";Object.defineProperties(exports,{__esModule:{value:!0},[Symbol.toStringTag]:{value:"Module"}});const r=require("vue"),p=require("@vue-youtube/core"),n=require("@vue-youtube/shared"),k=r.defineComponent({name:"YoutubeIframe",props:{width:{type:[String,Number],default:1280},height:{type:[String,Number],default:720},playerVars:{type:Object,default:()=>({autoplay:0,time:0,mute:0})},videoId:{type:String,default:""},cookie:{type:Boolean,default:!0}},emits:["playback-quality-change","playback-rate-change","state-change","api-change","error","ready"],setup(t,{emit:a,expose:u}){const{videoId:c}=r.toRefs(t),o=r.ref(),{instance:i,togglePlay:l,toggleMute:y,onPlaybackQualityChange:g,onPlaybackRateChange:h,onStateChange:d,onApiChange:s,onError:b,onReady:f}=p.usePlayer(c,o,{playerVars:t.playerVars,height:t.height,cookie:t.cookie,width:t.width});return g(e=>{a("playback-quality-change",e)}),h(e=>{a("playback-rate-change",e)}),d(e=>{a("state-change",e)}),s(e=>{a("api-change",e)}),b(e=>{a("error",e)}),f(e=>{a("ready",e)}),u({instance:i,togglePlay:l,toggleMute:y}),()=>r.h("div",{ref:o})}});exports.YoutubeIframe=k;for(const t in n)t!=="default"&&!exports.hasOwnProperty(t)&&Object.defineProperty(exports,t,{enumerable:!0,get:()=>n[t]});