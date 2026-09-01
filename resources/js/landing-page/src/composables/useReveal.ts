import { onMounted, onUnmounted } from 'vue'

export function useReveal(): void {
  let observer: IntersectionObserver | null = null
  let mutationObserver: MutationObserver | null = null

  function observeElements(root: ParentNode = document) {
    root
      .querySelectorAll<HTMLElement>('.reveal, .reveal-left, .reveal-right, .reveal-scale')
      .forEach((el) => {
        if (observer && !el.classList.contains('revealed')) {
          observer.observe(el)
        }
      })
  }

  onMounted(() => {
    observer = new IntersectionObserver(
      (entries: IntersectionObserverEntry[]) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            entry.target.classList.add('revealed')
            observer?.unobserve(entry.target)
          }
        })
      },
      { threshold: 0.15, rootMargin: '0px 0px -40px 0px' }
    )

    observeElements()

    mutationObserver = new MutationObserver((mutations) => {
      for (const mutation of mutations) {
        for (const node of mutation.addedNodes) {
          if (node instanceof HTMLElement) {
            observeElements(node)
          }
        }
      }
    })

    mutationObserver.observe(document.body, { childList: true, subtree: true })
  })

  onUnmounted(() => {
    observer?.disconnect()
    mutationObserver?.disconnect()
  })
}
