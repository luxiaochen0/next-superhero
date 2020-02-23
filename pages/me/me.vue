<template>
	<view class="page page-fill">
		<view class="header">
			<view v-if="userIsLogin">
				<image src="../../static/icos/108x108.png" class="face"></image>
			</view>
			<view v-else>
				<image src="http://next-superhero-static.luxiaochen.com/group1/M00/00/05/CpoxxFw_-5-AFyVyAABLIH8xBTw233.png" class="face"></image>
			</view>
			
			<view class="info-wapper" v-if="userIsLogin">
				<view class="nickname">
					NEXT 学院
				</view>
				<view class="nav-info">ID:123abc</view>
			</view>
			<view v-else>
				<navigator url="../registLogin/registLogin">
					<view class="nickname regist-login">
						注册/登录
					</view>
				</navigator>
			</view>
			
			<view class="set-wapper" v-if="userIsLogin">
				<image src="../../static/icos/settings.png" class="settings"></image>
			</view>

		</view>
	</view>
</template>

<script>
	export default {
		data() {
			return {
				userIsLogin:false
			}
		},
		methods: {
			
		}
	}
</script>

<style>
@import url("me.css");
</style>
