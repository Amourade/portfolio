import { inject as N, shallowRef as Q, ref as p, watch as j, onMounted as x, unref as B, onUnmounted as H } from "vue";
import { PROVIDE_KEY as P, unrefElement as q, HOST_COOKIE as D, HOST_NO_COOKIE as G, PlayerState as U } from "@/plugins/@vue-youtube/shared";
export * from "@/plugins/@vue-youtube/shared";
const $ = () => {
  const i = N(P);
  if (!i)
    throw new Error("You may forget to apply app.use(manager). See https://vue-youtube.github.io/docs/usage/manager.html for more information");
  return i;
}, J = () => {
  const f = {
    install(r) {
      r.provide(P, f), this._insert();
    },
    register(r, l) {
      const n = r.id || `vue-youtube-${this.state.counter++}`, s = this.state.players.get(n);
      if (s !== void 0) {
        s({
          factory: this.state.factory,
          id: n
        });
        return;
      }
      if (this.state.factory !== void 0) {
        l({
          factory: this.state.factory,
          id: n
        });
        return;
      }
      this.state.backlog.set(n, l);
    },
    _insert() {
      var n;
      const r = document.createElement("script");
      r.src = "https://www.youtube.com/player_api";
      const l = document.querySelectorAll("script")[0];
      (n = l.parentNode) == null || n.insertBefore(r, l), window.onYouTubeIframeAPIReady = () => {
        this.state.factory = window.YT;
        for (const [s, y] of this.state.backlog.entries())
          this.state.backlog.delete(s), this.state.players.set(s, y), y({
            factory: this.state.factory,
            id: s
          });
      };
    },
    state: {
      backlog: /* @__PURE__ */ new Map(),
      players: /* @__PURE__ */ new Map(),
      factory: void 0,
      counter: 1
    }
  };
  return f;
}, W = (i, f, r = {}) => {
  const {
    playerVars: l = {},
    cookie: n = !0,
    width: s = 1280,
    height: y = 720
  } = r, S = n ? D : G, A = $(), d = new Array(), v = new Array(), b = new Array(), m = new Array(), w = new Array(), C = new Array(), a = Q(), k = p(i), g = p(!1), h = p(!1), u = (e, t) => {
    for (const c of t)
      c(e);
  }, I = (...e) => {
    d.push(...e);
  }, E = (...e) => {
    v.push(...e);
  }, M = (...e) => {
    b.push(...e);
  }, O = (...e) => {
    m.push(...e);
  }, R = (...e) => {
    w.push(...e);
  }, _ = (...e) => {
    C.push(...e);
  }, T = () => {
    var t, c, o;
    const e = (t = a.value) == null ? void 0 : t.getPlayerState();
    if (e && e === U.PLAYING) {
      (c = a.value) == null || c.pauseVideo();
      return;
    }
    (o = a.value) == null || o.playVideo();
  }, V = () => {
    var e, t;
    if ((e = a.value) != null && e.isMuted()) {
      a.value.unMute();
      return;
    }
    (t = a.value) == null || t.mute();
  }, Y = () => {
    var e, t;
    if (g.value) {
      (e = a.value) == null || e.setShuffle(!1), g.value = !1;
      return;
    }
    (t = a.value) == null || t.setShuffle(!0), g.value = !0;
  }, L = () => {
    var e, t;
    if (h.value) {
      (e = a.value) == null || e.setLoop(!1), h.value = !1;
      return;
    }
    (t = a.value) == null || t.setLoop(!0), h.value = !0;
  }, K = j(k, (e) => {
    var t;
    (t = a.value) == null || t.loadVideoById(e);
  });
  return x(() => {
    const e = q(f);
    !e || A.register(e, ({ factory: t, id: c }) => {
      e.id = c, a.value = new t.Player(c, {
        videoId: B(k),
        playerVars: l,
        height: y,
        width: s,
        host: S,
        events: {
          onPlaybackQualityChange: (o) => {
            u(o, d);
          },
          onPlaybackRateChange: (o) => {
            u(o, v);
          },
          onStateChange: (o) => {
            u(o, b);
          },
          onApiChange: (o) => {
            u(o, m);
          },
          onError: (o) => {
            u(o, w);
          },
          onReady: (o) => {
            u(o, C);
          }
        }
      });
    });
  }), H(() => {
    var e;
    (e = a.value) == null || e.destroy(), K();
  }), {
    instance: a,
    togglePlay: T,
    toggleMute: V,
    toggleLoop: L,
    toggleShuffle: Y,
    onPlaybackQualityChange: I,
    onPlaybackRateChange: E,
    onStateChange: M,
    onApiChange: O,
    onError: R,
    onReady: _
  };
};
export {
  J as createManager,
  $ as injectManager,
  W as usePlayer
};
