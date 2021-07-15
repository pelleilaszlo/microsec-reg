<template>
	<div :class="data_class" role="alert" v-if="items.length>0">
		<div v-for="error in items">
			<strong>{{ error }}</strong>
		</div>
	</div>
</template>

<script>
	export default {
		name: "error-message",
		props: {
			'response': {
				type: Object,
				required: true
			},
			'field': {
				type: String,
				required: true
			},
			'data_class': {
				type: String,
				default: 'invalid-feedback',
				required: false
			}
		},
		computed: {
			items() {
				let errors = _.get(this.response, 'error.'+this.field);
				if (errors) {
					if (typeof errors === 'string') {
						return [errors];
					}
					return errors;
				}
				return [];
			}
		}
	}
</script>

<style scoped>

</style>
