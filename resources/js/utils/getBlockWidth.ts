export function getBlockWidth(length: number): string {
  switch (length) {
    case 1:
      return `max-w-[350px] sm:max-w-[500px] md:max-w-[500px] lg:max-w-[450px] xl:max-w-[600px] 2xl:max-w-[700px]`;
    case 2:
      return `max-w-[350px] sm:max-w-[500px] md:max-w-[500px] lg:max-w-[450px] xl:max-w-[600px] 2xl:max-w-[700px]`;
    case 3:
      return `max-w-[300px] lg:max-w-[450px] xl:max-w-[500px] 2xl:max-w-[600px]`;
    case 4:
      return `max-w-[200px] sm:max-w-[300px] lg:max-w-[450px] xl:max-w-[500px] 2xl:max-w-[600px]`;
    case 5:
      return `max-w-[200px] lg:max-w-[300px] xl:max-w-[400px] 2xl:max-w-[550px]`;
    case 6:
      return `max-w-[200px] lg:max-w-[300px] xl:max-w-[400px] 2xl:max-w-[550px]`;
    case 7:
      return `max-w-[200px] sm:max-w-[250px] lg:max-w-[300px] xl:max-w-[300px] 2xl:max-w-[450px]`;
    case 8:
      return `max-w-[200px] sm:max-w-[250px] lg:max-w-[300px] xl:max-w-[300px] 2xl:max-w-[450px]`;
    case 9:
      return `max-w-[200px] sm:max-w-[200px] lg:max-w-[200px] xl:max-w-[300px] 2xl:max-w-[400px]`;
    case 10:
      return `max-w-[200px] sm:max-w-[200px] lg:max-w-[200px] xl:max-w-[300px] 2xl:max-w-[400px]`;
    case 11:
      return `max-w-[200px] sm:max-w-[200px] lg:max-w-[200px] xl:max-w-[300px] 2xl:max-w-[400px]`;
    case 12:
      return `max-w-[200px] sm:max-w-[200px] lg:max-w-[200px] xl:max-w-[300px] 2xl:max-w-[400px]`;
    default:
      return `max-w-[200px] sm:max-w-[150px] lg:max-w-[150px] xl:max-w-[200px] 2xl:max-w-[300px]`;
  }
}

export function getSubBlockWidth(length: number): string {
  switch (length) {
    case 1:
      return 'h-40 w-40';
    case 2:
      return 'h-56 w-56';
    case 3:
      return 'h-44 w-44';
    case 4:
      return 'h-40 w-40';
    case 5:
      return 'h-32 w-32';
    case 6:
      return 'h-32 w-32';
    case 7:
      return 'h-28 w-28';
    case 8:
      return 'h-28 w-28';
    case 9:
      return 'h-28 w-28';
    case 10:
      return 'h-28 w-28';
    case 11:
      return 'h-24 w-24';
    case 12:
      return 'h-24 w-24';
    default:
      return 'w-20 h-20';
  }
}