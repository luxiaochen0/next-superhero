<template>
	<view class="page">
		<swiper :indicator-dots="true" :autoplay="true" :interval="3000" :duration="1000">
			<!-- <swiper-item>
				<image src="../../static/carousel/batmanvssuperman.png" mode="" class="carousel"></image>
			</swiper-item>
			<swiper-item>
				<image src="../../static/carousel/spiderman.png" mode=""></image>
			</swiper-item> -->
			<swiper-item v-for="(carousel,index) in carouselList" :key=index>
				<image :src="carousel.image" mode="" class="carousel"></image>
			</swiper-item>
		</swiper>
		
		<view class="page-block super-hot">
			<view class="hot-title-wapper">
				<image src="../../static/icos/hot.png" mode="" class="hot-ico"></image>
				<view class="hot-title">
					热门
				</view>
			</view>
		</view>
		
		<scroll-view scroll-x="true" class="page-block hot">
			<view class="single-poster" v-for="(superhero,index) in hotSuperheroList" :key=index>
				<view class="poster-wapper">
					<image :src="superhero.cover" mode="" class="poster"></image>
					<view class="movie-name">
						{{superhero.name}}
					</view>
					<trailerStars innerScore="10"></trailerStars>
				</view>
			</view>
		</scroll-view>
		
	</view>
</template>

<script>
	import common from "../../common/common.js"
	import trailerStars from "../../components/trailerStars.vue"
	export default {
		components:{trailerStars},
		data() {
			return {
				carouselList: [],
				hotSuperheroList:[]
			}
		},
		onLoad() {
			//var _this=this;
			var serverUrl=common.serverUrl;
			//请求轮播图数据
			uni.request({
			    url: serverUrl+'/index-carousel-list.json', 
			    method:"GET",
				success: (res) => {//箭头函数不需要_this
			        //console.log(res.data);
					if(res.data.status==200){
						var carouselList=res.data.data;
						this.carouselList=carouselList;
					}
			    }
			});
			
			//查询热门
			uni.request({
			    url: serverUrl+'/index-movie-hot-superhero.json', 
			    method:"GET",
				success: (res) => {//箭头函数不需要_this
			        //console.log(res.data);
					if(res.data.status==200){
						var hotSuperheroList=res.data.data;
						this.hotSuperheroList=hotSuperheroList;
					}
			    }
			});
		},
		methods: {

		}
	}
</script>

<style>
	@import url("index.css");
</style>
