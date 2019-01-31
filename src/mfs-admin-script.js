/**
 * Contains Admin Script.
 */

const admin = {
	init () {
		let listButtons = document.querySelectorAll( '.tag-list li button' )

		Array.from( listButtons ).forEach( button => {
			button.addEventListener( 'click', function ( e ) {
				let self = this
				let tag = self.dataset.value

				let input = document.getElementById( self.dataset.field )

				input.addEventListener( 'focus', function ( ev ) {
					let input = ev.target
					let cursor = input.selectionStart
					let endCursor = cursor + tag.length

					input.value = input.value.substring( 0, cursor ) + tag + input.value.substring( cursor )

					input.selectionEnd = endCursor

					this.removeEventListener( 'focus', arguments.callee, true )

				}, true )

				input.focus()

			}, true )

		} )
	},
}

admin.init()
