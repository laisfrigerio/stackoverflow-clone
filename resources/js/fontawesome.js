import { library, dom } from '@fortawesome/fontawesome-svg-core'
import {faCaretUp} from '@fortawesome/free-solid-svg-icons/faCaretUp'
import {faCaretDown} from '@fortawesome/free-solid-svg-icons/faCaretDown'
import {faStar} from '@fortawesome/free-solid-svg-icons/faStar'
import {faCheck} from '@fortawesome/free-solid-svg-icons/faCheck'

library.add([
  faCaretUp,
  faCaretDown,
  faStar,
  faCheck
]);

dom.watch();