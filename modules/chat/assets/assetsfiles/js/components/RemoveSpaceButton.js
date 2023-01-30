import { get, post, showAppLoading, hideAppLoading } from '../library.js';
import Modal from './Modal.js';

const { toRefs, ref, onUpdated, nextTick, watch, onMounted } = Vue;

export default {
	props: ['activeSpace'],
	components: {
		Modal,
	},
	setup(props, { emit }) {
		const { activeSpace } = toRefs(props);
		

		const removeSpace = () => {
			Swal.fire({
		        title: "Are you sure?",
		        text: "You won\"t be able to revert this!",
		        icon: "warning",
		        showCancelButton: true,
		        confirmButtonText: "Confirm",
		        cancelButtonText: "No, cancel!",
		        reverseButtons: true
		    }).then(function(result) {
		        if (result.value) {
					showAppLoading('#chat-module', 'Removing Space...');
					post('default/remove-space', {space_id: activeSpace.value.id})
				    .then(response => {
				       	if (response.status == 'success') {
				       		// reload
				       	}
						hideAppLoading('#chat-module');
				    })
				    .catch(e => {
						hideAppLoading('#chat-module');

				    	console.log(e);
		            });
		        } 
		    });
		}
		

		return {
			activeSpace,
			removeSpace,
		}
	},
  	template: `
		<span>
            <a @click.prevent="removeSpace" href="#" class="navi-link">
				<span class="navi-icon">
					<span class="svg-icon svg-icon-md svg-icon-primary">
						<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
						    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
						        <rect x="0" y="0" width="24" height="24"/>
						        <path d="M6,8 L6,20.5 C6,21.3284271 6.67157288,22 7.5,22 L16.5,22 C17.3284271,22 18,21.3284271 18,20.5 L18,8 L6,8 Z" fill="#000000" fill-rule="nonzero"/>
						        <path d="M14,4.5 L14,4 C14,3.44771525 13.5522847,3 13,3 L11,3 C10.4477153,3 10,3.44771525 10,4 L10,4.5 L5.5,4.5 C5.22385763,4.5 5,4.72385763 5,5 L5,5.5 C5,5.77614237 5.22385763,6 5.5,6 L18.5,6 C18.7761424,6 19,5.77614237 19,5.5 L19,5 C19,4.72385763 18.7761424,4.5 18.5,4.5 L14,4.5 Z" fill="#000000" opacity="0.3"/>
						    </g>
						</svg>
					</span>
				</span>
				<span class="navi-text">Remove</span>
			</a> 
		</span>
	`
}
