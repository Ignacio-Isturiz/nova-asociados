import { Calendar } from '@fullcalendar/core'
import dayGridPlugin from '@fullcalendar/daygrid'
import timeGridPlugin from '@fullcalendar/timegrid'
import listPlugin from '@fullcalendar/list'
import interactionPlugin from '@fullcalendar/interaction'
import bootstrap5Plugin from '@fullcalendar/bootstrap5'
import esLocale from '@fullcalendar/core/locales/es'

document.addEventListener('DOMContentLoaded', () => {
  const el = document.getElementById('calendar')
  if (!el) return

  const calendar = new Calendar(el, {
    plugins: [dayGridPlugin, timeGridPlugin, listPlugin, interactionPlugin, bootstrap5Plugin],
    themeSystem: 'bootstrap5',
    locale: esLocale,

    headerToolbar: {
      left: 'prev,next today',
      center: 'title',
      right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
    },

    initialView: 'timeGridWeek',
    firstDay: 1,
    allDaySlot: false,
    nowIndicator: true,

    slotMinTime: '08:00:00',
    slotMaxTime: '18:00:00',
    initialScrollTime: '08:00:00',
    height: 'auto',
    expandRows: true,

    businessHours: {
      daysOfWeek: [1,2,3,4,5],
      startTime: '08:00',
      endTime: '18:00',
    },

    events: '/citas/events',
    eventTimeFormat: { hour: '2-digit', minute: '2-digit', hour12: false },

    eventClick(info) {
        const ep = info.event.extendedProps || {}
        const estado = (ep.estado || '').toLowerCase()
      
        // ⛔ No permitir abrir si está cancelada
        if (estado === 'cancelada') {
          // opcional: avisar
          // alert('Esta cita está cancelada.');
          info.jsEvent.preventDefault()
          return
        }
        window.CitaEditModal?.open({
          id:       info.event.id,
          proyecto: ep.proyecto || info.event.title || '',
          estado:   ep.estado   || '',
          fecha:    ep.fecha    || (info.event.startStr ? info.event.startStr.substring(0,10) : ''),
          hora:     ep.hora     || (info.event.startStr ? info.event.startStr.substring(11,16) : ''),
        })
      },      
  })

  calendar.render()
})
