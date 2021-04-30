<template>
  <div class="video-list">
    <div
      id="video-wrap"
      :style="{
        transform: 'translate3d(' + moveTranslate + 'px, 0px, 0px)',
        width: width + 'px'
      }"
      @touchmove.passive="handleTouchMove"
      @touchstart.passive="handleTouchStart"
      @touchend.passive="handleTouchEnd"
    >
      <VideoCard v-for="video in videos" :key="video.video_id" :video="video" />
    </div>
  </div>
</template>

<script>
import VideoCard from './VideoCard';

export default {
  props: ['videos'],
  components: {
    VideoCard
  },
  data() {
    return {
      xDown: false,
      yDown: false,
      sliderSize: 340,
      moveLeft: false,
      moveRight: false,
      translate: 0,
      moveTranslate: 0,
      width: 6800,
      $videoWrap: null,
      videoPage: 1,
      videosLoading: false,
      maxWidth: 6800
    };
  },
  mounted() {
    // this.$videoWrap = document.getElementById('video-wrap');
    // this.$videoWrap.addEventListener('touchmove', this.handleTouchMove, {passive: true})
    // this.$videoWrap.addEventListener('touchstart', this.handleTouchStart, {passive: true})
    // this.$videoWrap.addEventListener('touchend', this.handleTouchEnd, {passive: true})
    //this.$videoWrap.style.width = (this.videos.length * this.sliderSize)+"px";
    this.width = this.videos.length * this.sliderSize;
  },
  methods: {
    getTouches(evt) {
      return (
        evt.touches || evt.originalEvent.touches // browser API
      ); // jQuery
    },
    handleTouchStart(evt) {
      const firstTouch = this.getTouches(evt)[0];
      this.xDown = firstTouch.clientX;
      this.yDown = firstTouch.clientY;
    },
    handleTouchEnd() {
      // Direction
      if (this.moveLeft) {
        this.moveChannel(true);
      } else if (this.moveRight) {
        this.moveChannel(false);
      }

      this.xDown = null;
      this.yDown = null;
      this.moveLeft = false;
      this.moveRight = false;
    },
    handleTouchMove(evt) {
      if (!this.xDown || !this.yDown) {
        return;
      }

      var distance = 30;

      var xUp = evt.touches[0].clientX;
      var yUp = evt.touches[0].clientY;

      var xDiff = this.xDown - xUp;
      var yDiff = this.yDown - yUp;

      if (Math.abs(xDiff) > Math.abs(yDiff)) {
        /*most significant*/

        if (xDiff > distance) {
          this.moveLeft = true;
          this.moveRight = false;
        } else if (xDiff < -distance) {
          this.moveRight = true;
          this.moveLeft = false;
        } else {
          this.moveLeft = false;
          this.moveRight = false;
        }
      } else {
        this.moveLeft = false;
        this.moveRight = false;
      }
    },
    moveChannel(left) {
      let videosOnScreen = this.$el.clientWidth / this.sliderSize;
      let videosToShow = Math.floor(videosOnScreen);
      let maxTranslate = this.maxWidth - this.sliderSize * videosToShow;

      // Figure out how big our slide holder needs to be to contain all videos.
      if (this.videos && this.videos.length) {
        this.maxWidth = this.videos.length * this.sliderSize;
      }

      // Direction
      if (left) {
        this.translate -= this.sliderSize;
      } else {
        this.translate += this.sliderSize;
      }

      if (this.translate > 0) {
        this.translate = 0;
      } else if (Math.abs(this.translate) > maxTranslate) {
        this.translate = -maxTranslate;
      }

      this.moveTranslate = this.translate;
    }
  }
};
</script>

<style scoped>
.video-list .card.video {
  width: 320px;
}

.video-list .card-img-back {
  width: 320px;
  height: 180px;
}

.video-list {
  white-space: nowrap;
  position: relative;
  overflow: hidden;
}

.video-list .card {
  margin-right: 20px;
}

.video-list .card:last-child {
  margin: 0;
}

#video-wrap {
  display: flex;
  transition: transform 0.2s ease-out;
}
</style>
