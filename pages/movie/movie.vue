<template>
	<view>
		<view class="player">
			<video :src="trailerInfo.trailer" :poster="trailerInfo.poster" class="movie" controls></video>
		</view>
		
		<view class="movie-info">
			<image :src="trailerInfo.cover" model="" class="cover"></image>
			<view class="movie-desc">
				<view class="title">{{trailerInfo.name}}</view>
				<view class="title">{{trailerInfo.basicInfo}}</view>
				<view class="title">{{trailerInfo.originalName}}</view>
				<view class="title">{{trailerInfo.totalTime}}</view>
				<view class="title">{{trailerInfo.releaseDate}}</view>
				<view class="score-block">
					
				</view>
			</view>
		</view>
	</view>
</template>

<script>
	import common from "../../common/common.js"
	export default {
		data() {
			return {
				trailerInfo:{}
			}
		},
		onLoad(params) {
			var trailerId=params.trailerId;
			
			uni.showLoading({
				mask:true,
				title:"请稍后"
			})
			
			var serverUrl=common.serverUrl;
			//查询猜你喜欢
			uni.request({
			    url: serverUrl+'/search/trailer', 
			    method:"GET",
				data:{id:trailerId},
				success: (res) => {//箭头函数不需要_this
			        //console.log(res.data);
					if(res.data.code==200){
						var trailerInfo=res.data.data;
						this.trailerInfo=trailerInfo;
						
					}
			    },complete() {
					uni.hideLoading();
			    }
			});
		},
		methods: {
			
		}
	}
</script>

<style>
@import url("movie.css");
</style>
