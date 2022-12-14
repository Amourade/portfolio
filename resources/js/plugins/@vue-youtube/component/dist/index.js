import { defineComponent as f, toRefs as b, ref as s, h as k } from "vue";
import { usePlayer as m } from "@/plugins/@vue-youtube/core";
export * from "@/plugins/@vue-youtube/shared";
const P = f({
  name: "YoutubeIframe",
  props: {
    width: {
      type: [String, Number],
      default: 1280
    },
    height: {
      type: [String, Number],
      default: 720
    },
    playerVars: {
      type: Object,
      default: () => ({
        autoplay: 0,
        time: 0,
        mute: 0
      })
    },
    videoId: {
      type: String,
      default: ""
    },
    cookie: {
      type: Boolean,
      default: !0
    }
  },
  emits: [
    "playback-quality-change",
    "playback-rate-change",
    "state-change",
    "api-change",
    "error",
    "ready"
  ],
  setup(t, { emit: a, expose: o }) {
    const { videoId: n } = b(t), r = s(), {
      instance: c,
      togglePlay: g,
      toggleMute: l,
      onPlaybackQualityChange: y,
      onPlaybackRateChange: h,
      onStateChange: i,
      onApiChange: u,
      onError: d,
      onReady: p
    } = m(n, r, {
      playerVars: t.playerVars,
      height: t.height,
      cookie: t.cookie,
      width: t.width
    });
    return y((e) => {
      a("playback-quality-change", e);
    }), h((e) => {
      a("playback-rate-change", e);
    }), i((e) => {
      a("state-change", e);
    }), u((e) => {
      a("api-change", e);
    }), d((e) => {
      a("error", e);
    }), p((e) => {
      a("ready", e);
    }), o({
      instance: c,
      togglePlay: g,
      toggleMute: l
    }), () => k("div", { ref: r });
  }
});
export {
  P as YoutubeIframe
};
