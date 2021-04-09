############ Libreria di connettori per l'implementazione di un Client Rest PHP ############

A seconda della famiglia di servizi Rest a cui connettersi vengono definiti:
 - Directory contenente le implementazioni dei singoli endpoint ed i rispettivi beanIn e beanOut
 - Service Factory
 - Common Factory

Il componente che esegue il servizio richiamato è il "VE1_BusinessProcessManager" che viene
invocato dalla Common Factory.
