<template name="trailerStars">
	<view class="movie-score-wapper">
		<!-- <image src="../../static/icos/star-yellow.png" mode="" class="star-ico"></image>
		<image src="../../static/icos/star-yellow.png" mode="" class="star-ico"></image>
		<image src="../../static/icos/star-yellow.png" mode="" class="star-ico"></image>
		<image src="../../static/icos/star-yellow.png" mode="" class="star-ico"></image>
		<image src="../../static/icos/star-gray.png" mode="" class="star-ico"></image>
		<view class="movie-score">
			9.0
		</view> -->
		
		<image v-for="(yello,index) in yelloScore" :key="index" src="../../static/icos/star-yellow.png" mode="" class="star-ico"></image>
		<image v-for="(gray,index) in grayScore" :key="'grey-'+index" src="../../static/icos/star-gray.png" mode="" class="star-ico"></image>
		<view class="movie-score" v-if="showNum==1">
			{{innerScore}}
		</view>
	</view>
</template>

<script>
	export default {
		name:"trailerStars",
		data() {
			return {
				yelloScore:0,
				grayScore:5
			};
		},
		props:{
			innerScore:0,//传入分数
			showNum:0  //传入1：显示 0 不显示
		},
		//组件创建完成后
		created() {
			var tempScore=0;
			if(this.innerScore!=null&&this.innerScore!=undefined&&this.innerScore!=''){
				tempScore=this.innerScore;
			}
			
			var yelloScore=parseInt(tempScore/2);
			var grayScore=5-yelloScore;
			this.yelloScore=yelloScore;
			this.grayScore=grayScore;
		}
	}
</script>

<style>
.movie-score-wapper{
	display: flex;
}

.star-ico{
	width: 20upx;
	height: 20upx;
	margin-top: 6upx;
}

.movie-score{
	font-size: 12px;
	color: grey;
	margin-left: 8upx;
}
</style>
