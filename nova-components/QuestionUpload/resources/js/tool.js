Nova.booting((Vue, router) => {
    router.addRoutes([
        {
            name: 'question-upload',
            path: '/question-upload',
            component: require('./components/Tool'),
        },
    ])
})
